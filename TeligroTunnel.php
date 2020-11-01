<?php
/**
 * Teligro PHP Tunnel
 * This is a sub package of Teligro plugin
 *
 * With PHP tunnel, you can send and receive request from another server as a tunnel.
 * This useful for website host location on the list of countries that have filtered the telegram.
 * Currently the telegram is filtered/blocked in Iran, Russia and China.
 *
 * Hot to use:
 * Upload the TeligroTunnel.php file to another server that can send / receive requests from the telegram.
 * Make sure the TeligroTunnel.php file directory has read and write permission.
 * Activate "WP Telegram Pro" plugin on your wordpress website.
 * Go to Settings page then Proxy tab, And select "PHP Tunnel" option.
 * Then enter "TeligroTunnel.php" URL on input box, For example: https://mydomain.tld/telegram-tunnel/TeligroTunnel.php
 *
 * @author Parsa Kafi
 * @link https://parsa.ws
 * @link WordPress Plugin: https://wordpress.org/plugins/teligro
 * @version 1.0
 * @license MIT
 */


// Debug Mode
define( 'DEBUG', false );

if ( DEBUG ) {
	ini_set( 'display_errors', 1 );
	ini_set( 'display_startup_errors', 1 );
	error_reporting( E_ALL );
}

class TeligroTunnel {

	/**
	 * Construct class
	 * Check request from Telegram and WPTP host
	 */
	public function __construct() {
		$requestMethod = $_SERVER['REQUEST_METHOD'];

		try {
			if ( $requestMethod === 'POST' ) {
				if ( isset( $_POST['set_webhook'] ) ) {
					$added = $this->addBot( $_POST['bot_username'], $_POST['webhook'] );
					echo json_encode( [ 'ok' => ! ! $added ] );

				} elseif ( isset( $_GET['bot'] ) && ! empty( $_GET['bot'] ) ) {
					$input = file_get_contents( 'php://input' );
					$data  = json_decode( $input, true );
					if ( json_last_error() !== JSON_ERROR_NONE || ! isset( $data['update_id'] ) ) {
						throw new \Exception( 'Json With Error!' );
					}

					$url = $this->getBotURL( $_GET['bot'] );

					if ( $url ) {
						$this->request( $url, $input );
					} else {
						die();
					}
				}

			} elseif ( $requestMethod === 'GET' && isset( $_GET['bot_token'] ) ) {
				$url = "https://api.telegram.org/bot{$_GET['bot_token']}/{$_GET['method']}";
				echo $this->request( $url, json_decode( $_GET['args'], true ), true );
			}

		} catch ( Exception $e ) {
			var_dump( $e );
		}
	}

	/**
	 * HTTP Request
	 *
	 * @param  string  $url  URL for send request
	 * @param  array|string  $data  Data for send to URL
	 * @param  bool  $toTelegram
	 *
	 * @return string
	 */
	function request( $url, $data, $toTelegram = false ) {
		$cookieFile = tempnam( "/tmp", 'TeligroTunnelCookie' );
		$agents     = array(
			'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1',
			'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.9) Gecko/20100508 SeaMonkey/2.0.4',
			'Mozilla/5.0 (Windows; U; MSIE 7.0; Windows NT 6.0; en-US)',
			'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_7; da-dk) AppleWebKit/533.21.1 (KHTML, like Gecko) Version/5.0.5 Safari/533.21.1'
		);

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );

		if ( ! $toTelegram ) {
			curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookieFile );
			curl_setopt( $ch, CURLOPT_COOKIEFILE, $cookieFile );
			curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
			curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );
			curl_setopt( $ch, CURLOPT_ENCODING, '' );
			curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
			curl_setopt( $ch, CURLOPT_REFERER, $url );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Content-Type: text/plain" ) );
			curl_setopt( $ch, CURLOPT_USERAGENT, $agents[ array_rand( $agents ) ] );
			curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
		}

		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

		$response = curl_exec( $ch );
		curl_close( $ch );

		return $response;
	}

	/**
	 * get bot URL from .botinfo file
	 *
	 * @param  string  $botUserName  Bot Username
	 *
	 * @return string|boolean
	 */
	function getBotURL( $botUserName ) {
		$file = $this->checkFile();
		$url  = false;
		if ( file_exists( $file ) ) {
			$myFile = fopen( $file, "r" ) or die( "Unable to open file!" );
			$json = json_decode( fread( $myFile, filesize( $file ) ), true );
			if ( array_key_exists( $botUserName, $json ) ) {
				$url = $json[ $botUserName ];
			}
		}

		return $url;
	}

	/**
	 * Add bot to .botinfo file
	 *
	 * @param  string  $botUserName  Bot Username
	 * @param  string  $webHook  WebHook URL
	 *
	 * @return boolean
	 */
	function addBot( $botUserName, $webHook ) {
		$file = $this->checkFile();
		if ( file_exists( $file ) ) {
			$myFile = fopen( $file, "w+" ) or die( "Unable to open file!" );
			$fileSize = filesize( $file );
			if ( $fileSize == 0 ) {
				$json = [];
			} else {
				$json = json_decode( fread( $myFile, $fileSize ), true );
			}
			$json[ $botUserName ] = $webHook;
			$json                 = json_encode( $json );
			$write                = fwrite( $myFile, $json );
			fclose( $myFile );

			return $write;
		}

		return false;
	}

	/**
	 * Check .botinfo file exists and if not created.
	 * @return string File path
	 */
	function checkFile() {
		$file = __DIR__ . DIRECTORY_SEPARATOR . '.botinfo';
		if ( ! file_exists( $file ) ) {
			$myFile = fopen( $file, "w" ) or die( "Unable to open file!" );
			fwrite( $myFile, "{}" );
			fclose( $myFile );
		}

		return $file;
	}
}

new TeligroTunnel();