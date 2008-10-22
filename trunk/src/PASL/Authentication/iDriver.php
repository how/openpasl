<?php
/**
 * OpenPASL
 *
 * Copyright (c) 2008, Danny Graham, Scott Thundercloud
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *   * Neither the name of the Danny Graham, Scott Thundercloud, nor the names of
 *     their contributors may be used to endorse or promote products derived from
 *     this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
 * OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @copyright Copyright (c) 2008, Danny Graham, Scott Thundercloud
 */

/**
 * Provides an interface for authentication drivers.
 *
 * @package PASL
 * @subpackage PASL_Authentication
 * @category Authentication
 * @author Danny Graham <good.midget@gmail.com>
 */
interface PASL_Authentication_iDriver
{
	/**
	 * Authenticate the user
	 *
	 * @param mixed User Credentials
	 * @return bool
	 */
	public function authenticate($credentials);

	/**
	 * Returns the last error response as an error Code/String array
	 *
	 * @return array An associate array with the following keys:
	 *  + errorCode: The int value code of the error
	 *  + errorString: The string value of the error
	 */
	public function getError();

	/**
	 * Sets a driver specific option.
	 * Some drivers may just have internal
	 * properties that are set, however some drivers may be adapters to
	 * other authentication objects and settings may need to be passed
	 * through. (In the case of a cURL or LDAP driver additional parameters
	 * would need to be passed through to the cURL or LDAP connector
	 * underneath.  Since we don't know where how these options are stored
	 * we'll let the driver implement this.
	 *
	 * @param string $key The option name or property value
	 * @param mixed $value The value that the option takes
	 * @return bool
	 */
	public function setOption($key, $value);

	/**
	 * Gets a driver specific option.
	 * Again, like setOption, we'll let the driver implement this.
	 *
	 * @param string $key The option name or property value to be returned
	 * @return mixed
	 */
	public function getOption($key);
}
?>