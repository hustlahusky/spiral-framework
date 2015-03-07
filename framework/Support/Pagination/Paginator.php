<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 * @copyright ©2009-2015
 */
namespace Spiral\Support\Pagination;

use Spiral\Core\Component;
use Spiral\Core\Dispatcher\RequestInterface;

class Paginator extends Component
{
    /**
     * The query array will be connected to every page URL generated by paginator. This will include the search query,
     * filters, etc.
     *
     * @var array
     */
    protected $queryArray = array();

    /**
     * Name of parameter in request query is used to store the current page number. By default, the "page" name will be used.
     *
     * @var string
     */
    protected $pageParameter = 'page';

    /**
     * Total number of pages.
     *
     * @var int
     */
    protected $countPages = 1;

    /**
     * Current page number.
     *
     * @var int
     */
    protected $current = 1;

    /**
     * Limit of Items per page.
     *
     * @var int
     */
    protected $limit = 25;

    /**
     * Total count of items.
     *
     * @var int
     */
    protected $count = 0;

    /**
     * Request instance.
     *
     * @invisible
     * @var RequestInterface
     */
    protected $request = null;

    /**
     * New paginator object is used to create page ranges, in addition to filtering database queries or arrays to select
     * a limited amount of records. By default, it can support ODM and ORM object, DBAL queries and arrays. To add support
     * for Pagination, simply implement pagination interface.
     *
     * @param string           $pageParameter Name of parameter in request query used to store current page number. By default,
     *                                        "page" is used.
     * @param RequestInterface $request       Request object created by HTTP dispatcher (page number will be fetched from query,
     *                                        if not HTTP request - from options).
     */
    public function __construct($pageParameter = 'page', RequestInterface $request = null)
    {
        $this->request = $request;
        $this->setParameter($pageParameter);
    }

    /**
     * Get page parameter name, paginator will automatically fetch page number from Request based on this parameter name.
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->pageParameter;
    }

    /**
     * Update page parameter name from request query. Page number will be fetched from query array (GET) of http\Request
     * or from options of dispatcher\Request.
     *
     * @param string|null $pageParameter New page parameter, page number will be fetched again after it is updated.
     * @return static
     */
    public function setParameter($pageParameter)
    {
        $this->pageParameter = $pageParameter;

        //Updating page number
        if ($this->request)
        {

        }

        //        if ($this->request instanceof \spiral\core\http\Request)
        //        {
        //            $this->setPage($this->request->query($this->pageParameter));
        //        }
        //        else
        //        {
        //            $this->setPage($this->request->option($this->pageParameter));
        //        }

        return $this;
    }

    /**
     * Manually force the page number should be used to filter and limit. Setting the page number after applying paginator
     * to object or array will not return any results. Method will return current page number.
     *
     * @param int $number Page number should be within the range of the highest page (1 - maxPages).
     * @return int
     */
    public function setPage($number = null)
    {
        $this->current = abs(intval($number));

        //Real page number
        return $this->getCurrentPage();
    }

    /**
     * The current page number.
     *
     * @return int
     */
    public function getCurrentPage()
    {
        if ($this->current < 1)
        {
            return 1;
        }

        if ($this->current > $this->countPages)
        {
            return $this->countPages;
        }

        return $this->current;
    }

    /**
     * Next page number. The return will be false if the current page is the last page.
     *
     * @return bool|int
     */
    public function getNextPage()
    {
        if ($this->getCurrentPage() != $this->countPages)
        {
            return $this->getCurrentPage() + 1;
        }

        return false;
    }

    /**
     * Previous page number. The return will be false if the current page is first page.
     *
     * @return bool|int
     */
    public function getPreviousPage()
    {
        if ($this->getCurrentPage() > 1)
        {
            return $this->getCurrentPage() - 1;
        }

        return false;
    }

    /**
     * To specify the amount of records you should use a specified limit. This method will update amount of available pages
     * in paginator.
     *
     * @param int $count Total records count.
     * @return Paginator
     */
    public function setCount($count)
    {
        $this->count = abs(intval($count));
        if ($this->count)
        {
            $this->countPages = ceil($this->count / $this->limit);
        }
        else
        {
            $this->countPages = 1;
        }

        return $this;
    }

    /**
     * The total count of record should be paginated. This can be set using setCount() method, or automatically by applying
     * paginator to object or array.
     *
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * The count of pages is needed to represent all records using a specified limit value.
     *
     * @return int
     */
    public function countPages()
    {
        return $this->countPages;
    }

    /**
     * The count or records displayed on current page can vary from 0 to any limit value. Only the last page will have less
     * records than is specified in the limit.
     *
     * @return int
     */
    public function countDisplayed()
    {
        return ($this->getCurrentPage() == $this->countPages) ? $this->count - $this->getOffset() : $this->limit;
    }

    /**
     * Amount of records per page.
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Specify limit - amount of records per page. This method will update the amount of available pages in paginator.
     *
     * @param int $limit Amount of records per page. Default is 50 records.
     * @return int
     */
    public function setLimit($limit = 50)
    {
        $this->limit = abs(intval($limit));
        if ($this->count)
        {
            $this->countPages = ceil($this->count / $this->limit);
        }
        else
        {
            $this->countPages = 1;
        }

        return $this->limit;
    }

    /**
     * The amount of records should be skipped from the start of the paginated sequence.
     *
     * @return int
     */
    public function getOffset()
    {
        return ($this->getCurrentPage() - 1) * $this->limit;
    }

    /**
     * Does paginator need to be shown? Return false if all records can be shown on one page.
     *
     * @return bool
     */
    public function isRequired()
    {
        return ($this->countPages > 1);
    }

    /**
     * Query array will be combined with every page URL generated by paginator. This can include search query, filters, etc.
     *
     * @return array
     */
    public function getQuery()
    {
        return $this->queryArray;
    }

    /**
     * Specify the query array which will be attached to every generated page URL. This cann include search query, filters, etc.
     *
     * @param array $queryArray Associated query array.
     * @param bool  $merge      New query array will be combined with an existing one without completely replacing it.
     */
    public function setQuery(array $queryArray, $merge = false)
    {
        $this->queryArray = $merge ? $queryArray + $this->queryArray : $queryArray;
    }

    /**
     * To apply pagination to a simple array, the following method will update the paginator total records count, regenerate
     * a list of pages and then will return an array fetched with limit and offset from the provided haystack.
     *
     * @param array $haystack Target array must be paginated.
     * @return array
     */
    public function paginateArray(array $haystack)
    {
        $this->setCount(count($haystack));

        return array_slice($haystack, $this->getOffset(), $this->limit);
    }

    /**
     * To apply the paginator to paginable object, the total records count should updated automatically by fetching the
     * value from the target object or it can be manually set without retrieving it by using the count() method. Method
     * will call object limit() and offset() functions. ODM, ORM and DBAL selectors are all supported.
     *
     * @param PaginableInterface $object     Object must be paginable.
     * @param bool               $fetchCount Fetch count from selection or set manually later.
     * @return PaginableInterface
     */
    public function paginateObject(PaginableInterface $object, $fetchCount = true)
    {
        $fetchCount && $this->setCount($object->count());

        $object->offset($this->getOffset());
        $object->limit($this->getLimit());

        return $object;
    }

    /**
     * Get the URL associated with a page number. The URL will include page parameter and query string built based on the
     * queryArray.
     *
     * @param int $number Valid page number. If no number is provided, the current page url will be returned without any
     *                    query.
     * @return string
     */
    public function buildURL($number = null)
    {
        $publicURL = "invalid-request";
        //        if ($this->request instanceof \spiral\core\http\Request)
        //        {
        //            $publicURL = $this->request->publicURL();
        //        }

        if (!$number)
        {
            return $publicURL;
        }

        return $publicURL . '?' . http_build_query($this->getQuery() + array($this->pageParameter => $number));
    }

    /**
     * Render the list of pages with its URL around current page.
     *
     * Example:
     * 1 ... 7 8 [9] 10 11 ... 67
     *
     * @param int  $interval The page count will show the before and after page based on the current page.
     * @param bool $showLast This will always show the last page's ID.
     * @return array
     */
    public function renderPages($interval = 4, $showLast = true)
    {
        //Current page
        $firstPage = max($this->getCurrentPage() - $interval, 1);
        $lastPage = min($this->getCurrentPage() + $interval, $this->countPages);

        $result = array();

        //First page was not included
        if ($firstPage != 1)
        {
            $result[1] = $this->buildURL(1);

            if ($firstPage != 2)
            {
                //Delimiter
                $result[] = '';
            }
        }

        //Page generation
        for ($pageNumber = $firstPage; $pageNumber <= $lastPage; $pageNumber++)
        {
            $result[$pageNumber] = $this->buildURL($pageNumber);
        }

        //Last page was not included
        if ($showLast && $lastPage != $this->countPages)
        {
            //Delimiter
            if ($lastPage != $this->countPages - 1)
            {
                //Delimiter
                $result[] = '';
            }

            $result[$this->countPages] = $this->buildURL($this->countPages);
        }
        elseif ($lastPage != $this->countPages)
        {
            $result[] = '';
        }

        return $result;
    }
}