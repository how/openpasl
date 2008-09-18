<?
/**
 * @license <http://www.opensource.org/licenses/bsd-license.php> BSD License
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
 */

/**
 * Page provides the base class for anything that's going out to the browser
 *
 * @package PASL_Web
 * @subpackage PASL_Web_Simpl
 * @category Web
 * @author Danny Graham <good.midget@gmail.com>
 */
class PASL_Web_Simpl_Page
{
	public $TOKENS = Array();
	public $Theme = "default";
	public $TemplateBasePath = "themes/default/templates/";

	/**
	 * References MainNav
	 *
	 * @var MainNav
	 */
	public $MainNav;
	/**
	 * References SubNav
	 *
	 * @var SubNav
	 */
	public $SubNav;
	/**
	 * References UserNav
	 *
	 * @var UserNav
	 */
	public $UserNav;

	public $PageTitle;
	public $SectionTitle;
	public $PageTemplate = "body_template.html";
	public $Body;
	public $JSPayload;
	public $JSScriptPayload;
	public $CSSPayload;
	public $CSSScriptPayload;

	private $JSPackages = Array();
	private $JSScriptPackages = Array();

	private $CSSPackages = Array();
	private $CSSScriptPackages = Array();

	private function updateJSPayload()
	{
		$JSPayload = "";
		foreach($JSPackages as $package)
		{
			$JSPayload .= '<script type="text/javascript" src="'.$url.'"></script>' . "\n";
		}
	}

	public function addJSPackage($url)
	{
		array_push($this->JSPackages, $url);
		$this->updateJSPayload();
	}

	public function updateJSScriptPayload()
	{
		$this->JSScriptPayload = '<script type="text/javascript">'."\n";

		foreach($this->JSScriptPackages as $package)
		{
			$this->JSScriptPayload = $package . "\n";
		}

		$this->JSScriptPayload .= "</script>\n";
	}

	public function addJSScriptPackage($script)
	{
		array_push($this->JSScriptPackages, $script);
		$this->updateJSScriptPayload();
	}

	public function updateCSSScriptPayload()
	{
		$this->CSSScriptPayload = '<style type="text/css">'."\n";

		foreach($this->CSSScriptPackages as $package)
		{
			$this->CSSScriptPayload .= $package . "\n";
		}

		$this->CSSScriptPayload .= "</style>\n";
	}

	public function addCSSScriptPackage($script)
	{
		array_push($this->CSSScriptPackages, $script);
		$this->updateCSSScriptPayload();
	}


	// Global Token Replacement For Specified Data
	private function parseData($data)
	{
		$body = $data;

		preg_match_all( "/\%(\S+?)\%/", $body, $matches );
		$tokens = array_values( array_unique( array_values( $matches[1] ) ) );

		for ($i = 0; $i < count($tokens); $i++)
		{
			if (isset($this->TOKENS[$tokens[$i]]))	$body = str_replace("%{$tokens[$i]}%", $this->TOKENS[$tokens[$i]], $body);
			else $body = str_replace("%{$tokens[$i]}%", "", $body);
		}
		return $body;
	}

	// Return local files that do not contain PHP or do not require execution.
	public function loadAndParse($url, $template=true)
	{
		ereg("http://",$url) ? $local = FALSE : $local = TRUE;

		$body = "";

		if ($local)
		{
			$file = array();
			$file = file(($template) ? $this->TemplateBasePath.$url : $url);
			foreach ($file as $line)
			{
				$body .= $line;
			}
		} else
		{
			$fp = fopen($url,"r");
			$body = fread($fp,1000000);
			fclose($fp);
		}

		$body = $this->parseData($body);
		return $body;
	}

	public function display()
	{
		print '<?xml version="1.0" encoding="UTF-8" ?>';
		require("themes/{$this->Theme}/{$this->PageTemplate}");
		exit;
	}
}

?>