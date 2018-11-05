Scrypt Password Hashing
=============

This class is an additional library (much like Zend\Crypt\Password\Bcrypt) used to generate scrypt password hashes that
are compatible with the [wg/scrypt](https://github.com/wg/scrypt) Java implementation. While it uses Zend\Crypt\Key\Derivation\Scrypt, 
it also adds the parameters to the returned string that are required to compare password hashes. Also included is a 
function to check the type of hash on your passwords. Useful if you are transitioning gradually from bcrypt to scrypt
 hashes.
 
While this library uses two Zend Framework 2 modules (Crypt and Math), there should be no impediment to using this in
 other frameworks or projects that utilize composer.

-------------

Installing via Composer
=======================
Install composer in a common location or in your project:

```bash
curl -s http://getcomposer.org/installer | php
```

Create the composer.json file as follows:

```json
{
    "require": {
        "moderndeveloperllc/scrypt" : "^1.0"
    }
}
```

Run the composer installer:

```bash
php composer.phar install
```

Usage
------------

### Hash a password

    <?php
    use ModDev\Password\Scrypt;
    
    $scrypt = new Scrypt();
    $securePass = $scrypt->create('user password');

### Check the hashed password against an user input

    <?php
    use ModDev\Password\Scrypt;
    
    $scrypt = new Scrypt();
    $securePass = 'the stored scrypt value';
    $password = 'the password to check';
    
    if ($scrypt->verify($password, $securePass)) {
        echo "The password is correct! \n";
    } else {
        echo "The password is NOT correct.\n";
    }

### Optional Parameters

    <?php
    use ModDev\Password\Scrypt;
    
    $scrypt = new Scrypt(array(
        'cpuDifficulty'      => 16384, //The CPU difficulty. Also called "N" in scrypt documentation. Must be a power of 2.
        'memoryDifficulty'   => 8, //The memory difficulty. Also called "r" in scrypt documentation.
        'parallelDifficulty' => 1, //The parallel difficulty. Also called "p" in scrypt documentation.
        'keyLength'          => 32, //The key length. Must be greater or equal to 16.
    ));

### Return the hash algorithm

    <?php
    use ModDev\Password\Scrypt;
    
    $scrypt = new Scrypt();
    $passwordhashType = $scrypt->getHashType($hashedPassword);

### Check if the password needs rehashing

    <?php
    use ModDev\Password\Scrypt;
    
    $scrypt = new Scrypt();
    echo $scrypt->needsRehash($hashedPassword);