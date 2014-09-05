<?php
class EncryptHelper extends Helper
{
    /**
	 * AES 128 Encryption
	**/
	function _fnEncrypt($sValue, $sSecretKey)
	{
		return rtrim(
			base64_encode(
				mcrypt_encrypt(
					MCRYPT_RIJNDAEL_128,
					$sSecretKey, $sValue, 
					MCRYPT_MODE_ECB, 
					mcrypt_create_iv(
						mcrypt_get_iv_size(
							MCRYPT_RIJNDAEL_128, 
							MCRYPT_MODE_ECB
						), 
					MCRYPT_RAND)
				)
			), "\0"
		);
	}
	
	/**
	 * AES 128 Decryption
	**/
	function _fnDecrypt($sValue, $sSecretKey)
	{
		return rtrim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_128, 
				$sSecretKey, 
				base64_decode($sValue), 
				MCRYPT_MODE_ECB,
				mcrypt_create_iv(
					mcrypt_get_iv_size(
						MCRYPT_RIJNDAEL_128,
						MCRYPT_MODE_ECB
					), 
					MCRYPT_RAND
				)
			), "\0"
		);
	}
	
} ?>