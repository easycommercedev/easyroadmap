<?php
namespace EasyRoadmap\Helper;

defined( 'ABSPATH' ) || exit;

/**
 * Email class to handle email template rendering.
 */
class Email {

	private $header;

	private $body;

	private $footer;

	private $subject;

	private $headers = array();

	private $attachments = array();

	private $recipients = array();

	/**
	 * Sets the header content.
	 *
	 * @param string $title The title for the email header.
	 */
	public function set_header( $title = '' ) {
		ob_start();
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title><?php echo esc_html( $title ); ?></title>
			<style>
				body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
				.header { background: #f8f8f8; padding: 20px; text-align: center; }
			</style>
		</head>
		<body>
			<div class="header">
				<h1><?php echo esc_html( $title ); ?></h1>
			</div>
		<?php
		$this->header = ob_get_clean();
	}

	/**
	 * Sets the body content.
	 *
	 * @param string $content The content for the email body.
	 */
	public function set_body( $content = '' ) {
		ob_start();
		?>
			<div class="body" style="padding: 20px;">
				<?php echo wp_kses_post( $content ); ?>
			</div>
		<?php
		$this->body = ob_get_clean();
	}

	/**
	 * Sets the footer content.
	 *
	 * @param string $content Optional additional content for the footer.
	 */
	public function set_footer( $content = '' ) {
		ob_start();
		?>
			<div class="footer" style="background: #f8f8f8; padding: 20px; text-align: center;">
				<p>&copy; <?php echo date( 'Y' ); ?> EasyRoadmap. All rights reserved.</p>
				<?php if ( $content ) : ?>
					<p><?php echo wp_kses_post( $content ); ?></p>
				<?php endif; ?>
			</div>
		</body>
		</html>
		<?php
		$this->footer = ob_get_clean();
	}

	/**
	 * Sets the subject of the email.
	 *
	 * @param string $subject The subject of the email.
	 */
	public function set_subject( $subject ) {
		$this->subject = $subject;
	}

	/**
	 * Adds a header to the email.
	 *
	 * @param string $header The header to add.
	 */
	public function add_header( $header ) {
		$this->headers[] = $header;
	}

	/**
	 * Adds an attachment to the email.
	 *
	 * @param string $attachment The file path of the attachment.
	 */
	public function add_attachment( $attachment ) {
		$this->attachments[] = $attachment;
	}

	/**
	 * Sets the recipient(s) of the email.
	 *
	 * @param mixed $recipients A single email address or an array of email addresses.
	 */
	public function set_recipient( $recipients ) {
		if ( is_array( $recipients ) ) {
			$this->recipients = $recipients;
		} else {
			$this->recipients = array( $recipients );
		}
	}

	/**
	 * Loads and sets the email template.
	 *
	 * @param string $template_name The name of the template file (without extension).
	 * @param array  $args Optional. Associative array of variables to pass to the template.
	 */
	public function set_template( $template_name, $args = array() ) {
		$template_path = EASYROADMAP_PLUGIN_DIR . 'views/emails/' . $template_name . '.php';

		if ( file_exists( $template_path ) ) {
			if ( ! empty( $args ) && is_array( $args ) ) {
				foreach ( $args as $key => $value ) {
					${$key} = $value;
				}
			}

			ob_start();
			include $template_path;
			$template_content = ob_get_clean();

			$this->set_body( $template_content );
		}
	}

	/**
	 * Sends the email.
	 *
	 * @return bool Whether the email was sent successfully.
	 */
	public function send() {
		$email_content = $this->header . $this->body . $this->footer;
		$to            = implode( ',', $this->recipients );
		return wp_mail( $to, $this->subject, $email_content, $this->headers, $this->attachments );
	}
}