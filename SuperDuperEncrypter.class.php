<?php
/***********************
	Nikházy Ákos

SuperDuperEncrypter.class.php a class

A very simple wrapper for openssl encryption with
two layer encryption outputting one iv value
tahta contains two ivs.
***********************/
class SuperDuperEncrypter{
	
	private $cipher1 = 'AES128';
	private $cipher2 = 'blowfish';
	
	public function encryptData($data,$key)
	{
		
		$iv1 = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher1));
		$iv1hex = bin2hex($iv1);
		
		$iv2 = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher2));
		$iv2hex = bin2hex($iv2);

		return array(
			'eD' => openssl_encrypt(
						openssl_encrypt($data ,$this->cipher1,hash('sha256',$iv2hex.$key).$key,0,$iv1),
					$this->cipher2,hash('sha256',$key.$iv1hex),0,$iv2),
			'iv' => bin2hex($iv1) . bin2hex($iv2)
			); 										
	}

	public function decryptData($data,$key,$iv)
	{
				
		$iv1hex  = substr($iv, 0, 32);
		$iv1 	 = hex2bin($iv1hex);
		
		$iv2hex	 = substr($iv, -16);
		$iv2	 = hex2bin($iv2hex);
		
		return openssl_decrypt(
					openssl_decrypt($data, $this->cipher2, hash('sha256',$key.$iv1hex), 0, $iv2), 
					$this->cipher1,hash('sha256',$iv2hex.$key).$key, 0, $iv1);
		
	}
	
}
