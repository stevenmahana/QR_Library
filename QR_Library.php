<?php
/**
 * QR Barcode Image Generator (PNG)
 *
 * @package QR Generator
 * @category QR Generator
 * @name QR Generator
 * @version 1.0
 * @author Steve Mahana 07.15
 * @link https://github.com/scantee/scantee
 * @link https://github.com/stevenmahana/QR_Library
 * @link Live at http://Scantee.me
 * @license http://www.gnu.org/licenses/gpl.html GPL License
 * This is free software and is distributed WITHOUT ANY WARRANTY
 */
final class QR_Library {
	/**
	 * Chart API URL
	 */
	const API_CHART_URL = "http://chart.apis.google.com/chart";

	private $_data;

	/**
	 * Generate QR code image
	 * @param int $size
	 * @param string $filename
	 * @return bool
	 */
	public function draw($size = 150, $filename = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, self::API_CHART_URL);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($this->_data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		$img = curl_exec($ch);
		curl_close($ch);

		if($img) {
			if($filename) {
				if(!preg_match("#\.png$#i", $filename)) {
					$filename .= ".png";
				}
				
				return file_put_contents($filename, $img);
			} else {
				header("Content-type: image/png");
				print $img;
				return true;
			}
		}

		return false;
	}
        
        
	/**
	 * Bookmark code
	 *
	 * @param string $title
	 * @param string $url
	 */
	public function bookmark($title = null, $url = null) {
		$this->_data = "MEBKM:TITLE:{$title};URL:{$url};;";
	}

	/**
	 * Create code with GIF, JPG, etc.
	 *
	 * @param string $type
	 * @param string $size
	 * @param string $content
	 */
	public function content($type = null, $size = null, $content = null) {
		$this->_data = "CNTS:TYPE:{$type};LNG:{$size};BODY:{$content};;";
	}        
        

	/**
	 * Email address code
	 *
	 * @param string $email
	 * @param string $subject
	 * @param string $message
	 */
	public function email($email = null, $subject = null, $message = null) {
		$this->_data = "MATMSG:TO:{$email};SUB:{$subject};BODY:{$message};;";
	}

	/**
	 * Geo location code
	 *
	 * @param string $lat
	 * @param string $lon
	 * @param string $height
	 */
	public function geo($lat = null, $lon = null, $height = null) {
		$this->_data = "GEO:{$lat},{$lon},{$height}";
	}
        

	/**
	 * MECARD code
	 *
	 * @param string $name
	 * @param string $address
	 * @param string $phone
	 * @param string $email
	 */
	public function mecard($name = null, $address = null, $phone = null, $email = null, $url = null, $note = null) {
		$this->_data = "MECARD:N:{$name};ADR:{$address};TEL:{$phone};EMAIL:{$email};URL:{$url};NOTE:{$note};;";
	}        
        

	/**
	 * Telephone number code
	 *
	 * @param string $phone
	 */
	public function phone($phone = null) {
		$this->_data = "TEL:{$phone}";
	}

	/**
	 * SMS code
	 *
	 * @param string $phone
	 * @param string $text
	 */
	public function sms($phone = null, $text = null) {
		$this->_data = "SMSTO:{$phone}:{$text}";
	}

	/**
	 * Text code
	 *
	 * @param string $text
	 */
	public function text($text = null) {
		$this->_data = $text;
	}

	/**
	 * URL code
	 *
	 * @param string $url
	 */
	public function url($url = null) {
		$this->_data = preg_match("#^https?\:\/\/#", $url) ? $url : "http://{$url}";
	}

	/**
	 * Wifi code
	 *
	 * @param string $type
	 * @param string $ssid
	 * @param string $password
	 */
	public function wifi($type = null, $ssid = null, $password = null) {
		$this->_data = "WIFI:T:{$type};S{$ssid};{$password};;";
	}
}
?>