<?php
/**
 * Tests the basics of the php 5.5 password_hash functions
 * 
 * @see http://php.net/manual/en/function.password-hash.php
 * @see https://github.com/ircmaxell/password_compat
 * @see http://www.sitepoint.com/hashing-passwords-php-5-5-password-hashing-api/
 */
class SimplePasswordHashTests extends PHPUnit_Framework_TestCase 
{
    protected $password = "";
    
    public function setUp()
    {
        parent::setUp();
        $this->password = "password";
    }
    
    public function testGeneratePasswordHash()
    {
        $hash = password_hash($this->password, PASSWORD_BCRYPT);
        $this->assertNotEmpty( $hash);
        return $hash;
    }
    
    /**
     * @depends testGeneratePasswordHash
     */
    public function testCheckPasswordHash($hash)
    {
        $this->assertTrue(password_verify($this->password, $hash));
    }
    
    public function testCheckPasswordHashFails()
    {
        $hash = password_hash("NeedMyHL3!", PASSWORD_BCRYPT);
        $this->assertFalse(password_verify($this->password, $hash));
    }
    
    public function testCheckPasswordHashingNeeded()
    {
        $old_hash = md5($this->password);
        $this->assertTrue(password_needs_rehash($old_hash,PASSWORD_BCRYPT));
    }
    
    public function testCheckOldPasswordHashingWontValidate()
    {
        $old_hash = md5($this->password);
        $this->assertFalse(password_verify($this->password,$old_hash));
    }
    /**
     * Not really a unit test--this is just demoing
     * how to pull it all together.
     */
    public function testDemonstrateAllTogether()
    {
        $password = $this->password;
        $hash = md5($password);
        $algorithm = PASSWORD_BCRYPT;
        
        if( (md5($password) == $hash) || 
            (password_verify($password,$algorithm ))) 
        {
            if (password_needs_rehash($hash, $algorithm)) {
            $new_hash = password_hash($password, $algorithm);
                /* Store new hash in db */
            $stored_password = $new_hash;
            }
        }
        $this->assertNotEquals($hash, $stored_password);
        $this->assertNotEquals($password, $stored_password);
    }
}