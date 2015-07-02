<?php
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 * @copyright ©2009-2015
 */
namespace Spiral\Components\Redis;

use Predis\Client;
use Spiral\Core\Container\InjectableInterface;

/**
 * Following methods will be called via magic method and applied to default connection.
 *
 * @method mixed del(array $keys)
 * @method mixed dump($key)
 * @method mixed exists($key)
 * @method mixed expire($key, $seconds)
 * @method mixed expireat($key, $timestamp)
 * @method mixed keys($pattern)
 * @method mixed move($key, $db)
 * @method mixed object($subcommand, $key)
 * @method mixed persist($key)
 * @method mixed pexpire($key, $milliseconds)
 * @method mixed pexpireat($key, $timestamp)
 * @method mixed pttl($key)
 * @method mixed randomkey()
 * @method mixed rename($key, $target)
 * @method mixed renamenx($key, $target)
 * @method mixed scan($cursor, array $options = null)
 * @method mixed sort($key, array $options = null)
 * @method mixed ttl($key)
 * @method mixed type($key)
 * @method mixed append($key, $value)
 * @method mixed bitcount($key, $start = null, $end = null)
 * @method mixed bitop($operation, $destkey, $key)
 * @method mixed decr($key)
 * @method mixed decrby($key, $decrement)
 * @method mixed get($key)
 * @method mixed getbit($key, $offset)
 * @method mixed getrange($key, $start, $end)
 * @method mixed getset($key, $value)
 * @method mixed incr($key)
 * @method mixed incrby($key, $increment)
 * @method mixed incrbyfloat($key, $increment)
 * @method mixed mget(array $keys)
 * @method mixed mset(array $dictionary)
 * @method mixed msetnx(array $dictionary)
 * @method mixed psetex($key, $milliseconds, $value)
 * @method mixed set($key, $value, $expireResolution = null, $expireTTL = null, $flag = null)
 * @method mixed setbit($key, $offset, $value)
 * @method mixed setex($key, $seconds, $value)
 * @method mixed setnx($key, $value)
 * @method mixed setrange($key, $offset, $value)
 * @method mixed strlen($key)
 * @method mixed hdel($key, array $fields)
 * @method mixed hexists($key, $field)
 * @method mixed hget($key, $field)
 * @method mixed hgetall($key)
 * @method mixed hincrby($key, $field, $increment)
 * @method mixed hincrbyfloat($key, $field, $increment)
 * @method mixed hkeys($key)
 * @method mixed hlen($key)
 * @method mixed hmget($key, array $fields)
 * @method mixed hmset($key, array $dictionary)
 * @method mixed hscan($key, $cursor, array $options = null)
 * @method mixed hset($key, $field, $value)
 * @method mixed hsetnx($key, $field, $value)
 * @method mixed hvals($key)
 * @method mixed blpop(array $keys, $timeout)
 * @method mixed brpop(array $keys, $timeout)
 * @method mixed brpoplpush($source, $destination, $timeout)
 * @method mixed lindex($key, $index)
 * @method mixed linsert($key, $whence, $pivot, $value)
 * @method mixed llen($key)
 * @method mixed lpop($key)
 * @method mixed lpush($key, array $values)
 * @method mixed lpushx($key, $value)
 * @method mixed lrange($key, $start, $stop)
 * @method mixed lrem($key, $count, $value)
 * @method mixed lset($key, $index, $value)
 * @method mixed ltrim($key, $start, $stop)
 * @method mixed rpop($key)
 * @method mixed rpoplpush($source, $destination)
 * @method mixed rpush($key, array $values)
 * @method mixed rpushx($key, $value)
 * @method mixed sadd($key, array $members)
 * @method mixed scard($key)
 * @method mixed sdiff(array $keys)
 * @method mixed sdiffstore($destination, array $keys)
 * @method mixed sinter(array $keys)
 * @method mixed sinterstore($destination, array $keys)
 * @method mixed sismember($key, $member)
 * @method mixed smembers($key)
 * @method mixed smove($source, $destination, $member)
 * @method mixed spop($key)
 * @method mixed srandmember($key, $count = null)
 * @method mixed srem($key, $member)
 * @method mixed sscan($key, $cursor, array $options = null)
 * @method mixed sunion(array $keys)
 * @method mixed sunionstore($destination, array $keys)
 * @method mixed zadd($key, array $membersAndScoresDictionary)
 * @method mixed zcard($key)
 * @method mixed zcount($key, $min, $max)
 * @method mixed zincrby($key, $increment, $member)
 * @method mixed zinterstore($destination, array $keys, array $options = null)
 * @method mixed zrange($key, $start, $stop, array $options = null)
 * @method mixed zrangebyscore($key, $min, $max, array $options = null)
 * @method mixed zrank($key, $member)
 * @method mixed zrem($key, $member)
 * @method mixed zremrangebyrank($key, $start, $stop)
 * @method mixed zremrangebyscore($key, $min, $max)
 * @method mixed zrevrange($key, $start, $stop, array $options = null)
 * @method mixed zrevrangebyscore($key, $min, $max, array $options = null)
 * @method mixed zrevrank($key, $member)
 * @method mixed zunionstore($destination, array $keys, array $options = null)
 * @method mixed zscore($key, $member)
 * @method mixed zscan($key, $cursor, array $options = null)
 * @method mixed zrangebylex($key, $start, $stop, array $options = null)
 * @method mixed zremrangebylex($key, $min, $max)
 * @method mixed zlexcount($key, $min, $max)
 * @method mixed pfadd($key, array $elements)
 * @method mixed pfmerge($destinationKey, array $sourceKeys)
 * @method mixed pfcount(array $keys)
 * @method mixed pubsub($subcommand, $argument)
 * @method mixed publish($channel, $message)
 * @method mixed discard()
 * @method mixed exec()
 * @method mixed multi()
 * @method mixed unwatch()
 * @method mixed watch($key)
 * @method mixed eval($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed evalsha($script, $numkeys, $keyOrArg1 = null, $keyOrArgN = null)
 * @method mixed script($subcommand, $argument = null)
 * @method mixed auth($password)
 * @method mixed echo ($message)
 * @method mixed ping($message = null)
 * @method mixed select($database)
 * @method mixed bgrewriteaof()
 * @method mixed bgsave()
 * @method mixed config($subcommand, $argument = null)
 * @method mixed dbsize()
 * @method mixed flushall()
 * @method mixed flushdb()
 * @method mixed info($section = null)
 * @method mixed lastsave()
 * @method mixed save()
 * @method mixed slaveof($host, $port)
 * @method mixed slowlog($subcommand, $argument = null)
 * @method mixed time()
 * @method mixed client($subcommand, $argument = null)
 * @method array command()
 */
class RedisClient extends Client implements InjectableInterface
{
    /**
     * InjectableInterface declares to spiral Container that requested interface or class should
     * not be resolved using default mechanism. Following interface does not require any methods,
     * however class or other interface which inherits InjectableInterface should declare constant
     * named "INJECTION_MANAGER" with name of class responsible for resolving that injection.
     *
     * InjectionFactory will receive requested class or interface reflection and reflection linked
     * to parameter in constructor or method used to declare injection.
     */
    const INJECTION_MANAGER = RedisManager::class;
}