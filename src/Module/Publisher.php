<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Module;

use Spiral\Boot\DirectoriesInterface;
use Spiral\Files\FilesInterface;
use Spiral\Module\Exception\PublishException;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Published files and directories.
 */
final class Publisher implements PublisherInterface
{
    /** @var FilesInterface */
    private $files = null;

    /** @var DirectoriesInterface */
    private $directories = null;

    /**
     * @param FilesInterface       $files
     * @param DirectoriesInterface $directories
     */
    public function __construct(FilesInterface $files, DirectoriesInterface $directories)
    {
        $this->files = $files;
        $this->directories = $directories;
    }

    /**
     * {@inheritdoc}
     */
    public function publish(
        string $filename,
        string $destination,
        string $mergeMode = self::FOLLOW,
        int $mode = FilesInterface::READONLY
    ) {
        if (!$this->files->isFile($filename)) {
            throw new PublishException("Given '{$filename}' is not valid file");
        }

        if ($this->files->exists($destination)) {
            if ($this->files->md5($destination) == $this->files->md5($filename)) {
                //Nothing to do
                return;
            }

            if ($mergeMode == self::FOLLOW) {
                return;
            }
        }

        $this->ensureDirectory(dirname($destination), $mode);
        echo 1;
        $this->files->copy($filename, $destination);
        $this->files->setPermissions($destination, $mode);

        clearstatcache();
    }

    /**
     * {@inheritdoc}
     */
    public function publishDirectory(
        string $directory,
        string $destination,
        string $mergeMode = self::REPLACE,
        int $mode = FilesInterface::READONLY
    ) {
        if (!$this->files->isDirectory($directory)) {
            throw new PublishException("Given '{$directory}' is not valid directory");
        }

        $finder = new Finder();
        $finder->files()->in($directory);

        /**
         * @var SplFileInfo $file
         */
        foreach ($finder->getIterator() as $file) {
            $this->publish(
                (string)$file,
                $destination . '/' . $file->getRelativePathname(),
                $mergeMode,
                $mode
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function ensureDirectory(string $directory, int $mode = FilesInterface::READONLY)
    {
        $this->files->ensureDirectory($directory, $mode);
    }
}
