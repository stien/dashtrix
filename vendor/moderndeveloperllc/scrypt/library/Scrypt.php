<?php
namespace ModDev\Password;

use Traversable;
use Zend\Crypt\Exception\InvalidArgumentException;
use Zend\Crypt\Key\Derivation\Scrypt as DerivationScrypt;
use Zend\Crypt\Password\PasswordInterface;
use Zend\Crypt\Utils;
use Zend\Math\Rand;
use Zend\Stdlib\ArrayUtils;

/**
 * Class to implement scrypt hashing in PHP. This provides hashes that use the same MCF as
 * {@see https://github.com/wg/scrypt} - a Java implementation of scrypt. While it utilizes a handful of Zend Framework
 * classes, this is not restricted to ZF2 projects.
 *
 * @see    http://www.tarsnap.com/scrypt.html
 * @see    https://tools.ietf.org/html/draft-josefsson-scrypt-kdf-01
 * @author Mark Garrett <mark@moderndeveloperllc.com>
 */
class Scrypt implements PasswordInterface
{

    /**
     * The MCF identifier for this version of the hashing algorithm.
     */
    const HASH_MFC_VERSION = 's0';

    /**
     * @var int The CPU difficulty. Also called "N" in scrypt documentation. Must be a power of 2.
     */
    private $cpuDifficulty = 16384;

    /**
     * @var int The memory difficulty. Also called "r" in scrypt documentation.
     */
    private $memoryDifficulty = 8;

    /**
     * @var int The parallel difficulty. Also called "p" in scrypt documentation.
     */
    private $parallelDifficulty = 1;

    /**
     * @var int The key length. Must be greater or equal to 16.
     */
    private $keyLength = 32;

    /**
     * Constructor
     *
     * @param array|Traversable $options
     * @throws InvalidArgumentException
     */
    public function __construct($options = array())
    {
        if (!empty($options)) {
            if ($options instanceof Traversable) {
                $options = ArrayUtils::iteratorToArray($options);
            } elseif (!is_array($options)) {
                throw new InvalidArgumentException(
                    'The options parameter must be an array or a Traversable'
                );
            }

            krsort($options);

            foreach ($options as $key => $value) {
                switch (strtolower($key)) {
                    case 'cpudifficulty':
                        $this->setCpuDifficulty($value);
                        break;
                    case 'memorydifficulty':
                        $this->setMemoryDifficulty($value);
                        break;
                    case 'paralleldifficulty':
                        $this->setParallelDifficulty($value);
                        break;
                    case 'keylength':
                        $this->setKeyLength($value);
                        break;
                }
            }
        }
    }

    /**
     * Create an scrypt password hash
     *
     * @param string $password The clear text password
     * @return string The hashed password
     */
    public function create($password)
    {
        $salt   = Rand::getBytes(32);
        $N      = $this->getCpuDifficulty();
        $r      = $this->getMemoryDifficulty();
        $p      = $this->getParallelDifficulty();
        $hash   = DerivationScrypt::calc($password, $salt, $N, $r, $p, $this->getKeyLength());
        $params = dechex(log($N, 2)) . sprintf('%02x', $r) . sprintf('%02x', $p);

        return '$' . self::HASH_MFC_VERSION . '$' . $params . '$' . base64_encode($salt) . '$' . base64_encode($hash);
    }

    /**
     * Check a clear text password against a hash
     *
     * @param string $password The clear text password
     * @param string $hash     The hashed password
     * @return boolean If the clear text matches
     */
    public function verify($password, $hash='')
    {
        // Is there actually a hash in the modified MCF format?
        if (!strlen($hash) || substr($hash, 0, 1) !== '$') {
          

            return false;
        }

        list ($version, $params, $salt, $encodedHash) = explode('$', substr($hash, 1), 5);

        // Do we have a version we can check?
        if ($version !== self::HASH_MFC_VERSION) {
            return false;
        }

        list($N, $r, $p) = $this->splitParams($params);

        // Any empty fields?
        if (empty($salt) || empty($hash) || !is_numeric($N) || !is_numeric($r) or !is_numeric($p)) {
            return false;
        }

        $calculated = DerivationScrypt::calc($password, base64_decode($salt), $N, $r, $p, $this->getKeyLength());

        // Use compareStrings to avoid timing attacks
        return Utils::compareStrings(base64_decode($encodedHash), $calculated);
    }

    /**
     * Return the CPU difficulty
     *
     * @return int
     */
    public function getCpuDifficulty()
    {
        return $this->cpuDifficulty;
    }

    /**
     * Set the CPU difficulty. This also checks validity of the input.
     *
     * @param int $cpuDifficulty
     */
    public function setCpuDifficulty($cpuDifficulty)
    {
        if ($cpuDifficulty == 0 || ($cpuDifficulty & ($cpuDifficulty - 1)) != 0) {
            throw new InvalidArgumentException("cpuDifficulty must be > 0 and a power of 2");
        }

        if ($cpuDifficulty > (PHP_INT_MAX / 128 / $this->getMemoryDifficulty())) {
            throw new InvalidArgumentException("cpuDifficulty is too large");
        }

        $this->cpuDifficulty = $cpuDifficulty;
    }

    /**
     * Return the memory difficulty
     *
     * @return int
     */
    public function getMemoryDifficulty()
    {
        return $this->memoryDifficulty;
    }

    /**
     * Set the memory difficulty. This also checks the validity of the input and validity of the CPU difficulty based on
     * the new memory difficulty number.
     *
     * @param int $memoryDifficulty
     */
    public function setMemoryDifficulty($memoryDifficulty)
    {
        if ($memoryDifficulty > (PHP_INT_MAX / 128 / $this->getParallelDifficulty())) {
            throw new InvalidArgumentException("parallelDifficulty is too large");
        }
        $this->memoryDifficulty = $memoryDifficulty;

        //CPU Difficulty has a check that relies on memory difficulty, so we need to check that we are still fine.
        $this->setCpuDifficulty($this->cpuDifficulty);
    }

    /**
     * Return the parallel difficulty
     *
     * @return int
     */
    public function getParallelDifficulty()
    {
        return $this->parallelDifficulty;
    }

    /**
     * Set the parallel difficulty.  This also checks the validity of the memory difficulty based on the new parallel
     * difficulty number.
     *
     * @param int $parallelDifficulty
     */
    public function setParallelDifficulty($parallelDifficulty)
    {
        $this->parallelDifficulty = $parallelDifficulty;

        //Memory Difficulty has a check that relies on parallel difficulty, so we need to check that we are still fine.
        $this->setMemoryDifficulty($this->memoryDifficulty);
    }

    /**
     * @return int
     */
    public function getKeyLength()
    {
        return $this->keyLength;
    }

    /**
     * @param int $keyLength
     */
    public function setKeyLength($keyLength)
    {
        if ($keyLength < 16) {
            throw new InvalidArgumentException("Key length is too low, must be greater or equal to 16");
        }

        $this->keyLength = $keyLength;
    }

    /**
     * Return the hash algorithm for a hashed password. Used primarily to check if the hashed password is bcrypt or
     * scrypt.
     *
     * @param string $hash The hashed password
     * @return string The hash algorithm. Returns 'unknown' if hash type not found.
     */
    public function getHashType($hash)
    {
        $hashParts = explode('$', $hash);

        switch ($hashParts[1]) {
            case self::HASH_MFC_VERSION:
                $type = 'scrypt';
                break;

            case '2a':
            case '2x':
            case '2y':
                $type = 'bcrypt';
                break;

            case '1':
                $type = 'md5';
                break;

            case '5':
                $type = 'sha-256';
                break;

            case '6':
                $type = 'sha-512';
                break;

            case 'sha1':
                $type = 'sha1';
                break;

            default:
                $type = 'unknown';
        }

        return $type;
    }

    /**
     * Split out the algorithm parameters from a hashed password's parameter string
     *
     * @param string $params The parameter string
     * @return array Array of parameters used to make this hash
     */
    private function splitParams($params)
    {
        $N = (int)pow(2, hexdec(substr($params, 0, -4)));
        $r = (int)hexdec(substr($params, -4, 2));
        $p = (int)hexdec(substr($params, -2, 2));

        return array($N, $r, $p);
    }

    /**
     * Functionality similar to password_needs_rehash() to checks to see if current hash is using the latest parameters.
     *
     * @param $hash string The hash to check
     * @return bool
     */
    public function needsRehash($hash)
    {
        $hashParts = explode('$', $hash);

        if ($hashParts[1] !== self::HASH_MFC_VERSION) {
            return true;
        }

        list($N, $r, $p) = $this->splitParams($hashParts[2]);

        if ($N !== $this->getCpuDifficulty()
            || $r !== $this->getMemoryDifficulty()
            || $p !== $this->getParallelDifficulty()
        ) {

            return true;
        }

        return false;
    }
}
