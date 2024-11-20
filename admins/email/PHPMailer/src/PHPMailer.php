<?php

/**
 * PHPMailer - PHP email creation and transport class.
 * PHP Version 5.5.
 *
 * @see https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 *
 * @author    Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author    Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author    Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author    Brent R. Matzelle (original founder)
 * @copyright 2012 - 2020 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note      This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace PHPMailer\PHPMailer;

/**
 * PHPMailer - PHP email creation and transport class.
 *
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author Brent R. Matzelle (original founder)
 */
class PHPMailer
{
    const CHARSET_ASCII = 'us-ascii';
    const CHARSET_ISO88591 = 'iso-8859-1';
    const CHARSET_UTF8 = 'utf-8';

    const CONTENT_TYPE_PLAINTEXT = 'text/plain';
    const CONTENT_TYPE_TEXT_CALENDAR = 'text/calendar';
    const CONTENT_TYPE_TEXT_HTML = 'text/html';
    const CONTENT_TYPE_MULTIPART_ALTERNATIVE = 'multipart/alternative';
    const CONTENT_TYPE_MULTIPART_MIXED = 'multipart/mixed';
    const CONTENT_TYPE_MULTIPART_RELATED = 'multipart/related';

    const ENCODING_7BIT = '7bit';
    const ENCODING_8BIT = '8bit';
    const ENCODING_BASE64 = 'base64';
    const ENCODING_BINARY = 'binary';
    const ENCODING_QUOTED_PRINTABLE = 'quoted-printable';

    const ENCRYPTION_STARTTLS = 'tls';
    const ENCRYPTION_SMTPS = 'ssl';

    const ICAL_METHOD_REQUEST = 'REQUEST';
    const ICAL_METHOD_PUBLISH = 'PUBLISH';
    const ICAL_METHOD_REPLY = 'REPLY';
    const ICAL_METHOD_ADD = 'ADD';
    const ICAL_METHOD_CANCEL = 'CANCEL';
    const ICAL_METHOD_REFRESH = 'REFRESH';
    const ICAL_METHOD_COUNTER = 'COUNTER';
    const ICAL_METHOD_DECLINECOUNTER = 'DECLINECOUNTER';

    /**
     * Email priority.
     * Options: null (default), 1 = High, 3 = Normal, 5 = low.
     * When null, the header is not set at all.
     *
     * @var int|null
     */
    public $Priority;

    /**
     * The character set of the message.
     *
     * @var string
     */
    public $CharSet = self::CHARSET_ISO88591;

    /**
     * The MIME Content-type of the message.
     *
     * @var string
     */
    public $ContentType = self::CONTENT_TYPE_PLAINTEXT;

    /**
     * The message encoding.
     * Options: "8bit", "7bit", "binary", "base64", and "quoted-printable".
     *
     * @var string
     */
    public $Encoding = self::ENCODING_8BIT;

    /**
     * Holds the most recent mailer error message.
     *
     * @var string
     */
    public $ErrorInfo = '';

    /**
     * The From email address for the message.
     *
     * @var string
     */
    public $From = '';

    /**
     * The From name of the message.
     *
     * @var string
     */
    public $FromName = '';

    /**
     * The envelope sender of the message.
     * This will usually be turned into a Return-Path header by the receiver,
     * and is the address that bounces will be sent to.
     * If not empty, will be passed via `-f` to sendmail or as the 'MAIL FROM' value over SMTP.
     *
     * @var string
     */
    public $Sender = '';

    /**
     * The Subject of the message.
     *
     * @var string
     */
    public $Subject = '';

    /**
     * An HTML or plain text message body.
     * If HTML then call isHTML(true).
     *
     * @var string
     */
    public $Body = '';

    /**
     * The plain-text message body.
     * This body can be read by mail clients that do not have HTML email
     * capability such as mutt & Eudora.
     * Clients that can read HTML will view the normal Body.
     *
     * @var string
     */
    public $AltBody = '';

    /**
     * An iCal message part body.
     * Only supported in simple alt or alt_inline message types
     * To generate iCal event structures, use classes like EasyPeasyICS or iCalcreator.
     *
     * @see http://sprain.ch/blog/downloads/php-class-easypeasyics-create-ical-files-with-php/
     * @see http://kigkonsult.se/iCalcreator/
     *
     * @var string
     */
    public $Ical = '';

    /**
     * Value-array of "method" in Contenttype header "text/calendar"
     *
     * @var string[]
     */
    protected static $IcalMethods = [
        self::ICAL_METHOD_REQUEST,
        self::ICAL_METHOD_PUBLISH,
        self::ICAL_METHOD_REPLY,
        self::ICAL_METHOD_ADD,
        self::ICAL_METHOD_CANCEL,
        self::ICAL_METHOD_REFRESH,
        self::ICAL_METHOD_COUNTER,
        self::ICAL_METHOD_DECLINECOUNTER,
    ];

    /**
     * The complete compiled MIME message body.
     *
     * @var string
     */
    protected $MIMEBody = '';

    /**
     * The complete compiled MIME message headers.
     *
     * @var string
     */
    protected $MIMEHeader = '';

    /**
     * Extra headers that createHeader() doesn't fold in.
     *
     * @var string
     */
    protected $mailHeader = '';

    /**
     * Word-wrap the message body to this number of chars.
     * Set to 0 to not wrap. A useful value here is 78, for RFC2822 section 2.1.1 compliance.
     *
     * @see static::STD_LINE_LENGTH
     *
     * @var int
     */
    public $WordWrap = 0;

    /**
     * Which method to use to send mail.
     * Options: "mail", "sendmail", or "smtp".
     *
     * @var string
     */
    public $Mailer = 'mail';

    /**
     * The path to the sendmail program.
     *
     * @var string
     */
    public $Sendmail = '/usr/sbin/sendmail';

    /**
     * Whether mail() uses a fully sendmail-compatible MTA.
     * One which supports sendmail's "-oi -f" options.
     *
     * @var bool
     */
    public $UseSendmailOptions = true;

    /**
     * The email address that a reading confirmation should be sent to, also known as read receipt.
     *
     * @var string
     */
    public $ConfirmReadingTo = '';

    /**
     * The hostname to use in the Message-ID header and as default HELO string.
     * If empty, PHPMailer attempts to find one with, in order,
     * $_SERVER['SERVER_NAME'], gethostname(), php_uname('n'), or the value
     * 'localhost.localdomain'.
     *
     * @see PHPMailer::$Helo
     *
     * @var string
     */
    public $Hostname = '';

    /**
     * An ID to be used in the Message-ID header.
     * If empty, a unique id will be generated.
     * You can set your own, but it must be in the format "<id@domain>",
     * as defined in RFC5322 section 3.6.4 or it will be ignored.
     *
     * @see https://tools.ietf.org/html/rfc5322#section-3.6.4
     *
     * @var string
     */
    public $MessageID = '';

    /**
     * The message Date to be used in the Date header.
     * If empty, the current date will be added.
     *
     * @var string
     */
    public $MessageDate = '';

    /**
     * SMTP hosts.
     * Either a single hostname or multiple semicolon-delimited hostnames.
     * You can also specify a different port
     * for each host by using this format: [hostname:port]
     * (e.g. "smtp1.example.com:25;smtp2.example.com").
     * You can also specify encryption type, for example:
     * (e.g. "tls://smtp1.example.com:587;ssl://smtp2.example.com:465").
     * Hosts will be tried in order.
     *
     * @var string
     */
    public $Host = 'localhost';

    /**
     * The default SMTP server port.
     *
     * @var int
     */
    public $Port = 25;

    /**
     * The SMTP HELO/EHLO name used for the SMTP connection.
     * Default is $Hostname. If $Hostname is empty, PHPMailer attempts to find
     * one with the same method described above for $Hostname.
     *
     * @see PHPMailer::$Hostname
     *
     * @var string
     */
    public $Helo = '';

    /**
     * What kind of encryption to use on the SMTP connection.
     * Options: '', static::ENCRYPTION_STARTTLS, or static::ENCRYPTION_SMTPS.
     *
     * @var string
     */
    public $SMTPSecure = '';

    /**
     * Whether to enable TLS encryption automatically if a server supports it,
     * even if `SMTPSecure` is not set to 'tls'.
     * Be aware that in PHP >= 5.6 this requires that the server's certificates are valid.
     *
     * @var bool
     */
    public $SMTPAutoTLS = true;

    /**
     * Whether to use SMTP authentication.
     * Uses the Username and Password properties.
     *
     * @see PHPMailer::$Username
     * @see PHPMailer::$Password
     *
     * @var bool
     */
    public $SMTPAuth = false;

    /**
     * Options array passed to stream_context_create when connecting via SMTP.
     *
     * @var array
     */
    public $SMTPOptions = [];

    /**
     * SMTP username.
     *
     * @var string
     */
    public $Username = '';

    /**
     * SMTP password.
     *
     * @var string
     */
    public $Password = '';

    /**
     * SMTP authentication type. Options are CRAM-MD5, LOGIN, PLAIN, XOAUTH2.
     * If not specified, the first one from that list that the server supports will be selected.
     *
     * @var string
     */
    public $AuthType = '';

    /**
     * An implementation of the PHPMailer OAuthTokenProvider interface.
     *
     * @var OAuthTokenProvider
     */
    protected $oauth;

    /**
     * The SMTP server timeout in seconds.
     * Default of 5 minutes (300sec) is from RFC2821 section 4.5.3.2.
     *
     * @var int
     */
    public $Timeout = 300;

    /**
     * Comma separated list of DSN notifications
     * 'NEVER' under no circumstances a DSN must be returned to the sender.
     *         If you use NEVER all other notifications will be ignored.
     * 'SUCCESS' will notify you when your mail has arrived at its destination.
     * 'FAILURE' will arrive if an error occurred during delivery.
     * 'DELAY'   will notify you if there is an unusual delay in delivery, but the actual
     *           delivery's outcome (success or failure) is not yet decided.
     *
     * @see https://tools.ietf.org/html/rfc3461 See section 4.1 for more information about NOTIFY
     */
    public $dsn = '';

    /**
     * SMTP class debug output mode.
     * Debug output level.
     * Options:
     * @see SMTP::DEBUG_OFF: No output
     * @see SMTP::DEBUG_CLIENT: Client messages
     * @see SMTP::DEBUG_SERVER: Client and server messages
     * @see SMTP::DEBUG_CONNECTION: As SERVER plus connection status
     * @see SMTP::DEBUG_LOWLEVEL: Noisy, low-level data output, rarely needed
     *
     * @see SMTP::$do_debug
     *
     * @var int
     */
    public $SMTPDebug = 0;

    /**
     * How to handle debug output.
     * Options:
     * * `echo` Output plain-text as-is, appropriate for CLI
     * * `html` Output escaped, line breaks converted to `<br>`, appropriate for browser output
     * * `error_log` Output to error log as configured in php.ini
     * By default PHPMailer will use `echo` if run from a `cli` or `cli-server` SAPI, `html` otherwise.
     * Alternatively, you can provide a callable expecting two params: a message string and the debug level:
     *
     * ```php
     * $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
     * ```
     *
     * Alternatively, you can pass in an instance of a PSR-3 compatible logger, though only `debug`
     * level output is used:
     *
     * ```php
     * $mail->Debugoutput = new myPsr3Logger;
     * ```
     *
     * @see SMTP::$Debugoutput
     *
     * @var string|callable|\Psr\Log\LoggerInterface
     */
    public $Debugoutput = 'echo';

    /**
     * Whether to keep the SMTP connection open after each message.
     * If this is set to true then the connection will remain open after a send,
     * and closing the connection will require an explicit call to smtpClose().
     * It's a good idea to use this if you are sending multiple messages as it reduces overhead.
     * See the mailing list example for how to use it.
     *
     * @var bool
     */
    public $SMTPKeepAlive = false;

    /**
     * Whether to split multiple to addresses into multiple messages
     * or send them all in one message.
     * Only supported in `mail` and `sendmail` transports, not in SMTP.
     *
     * @var bool
     *
     * @deprecated 6.0.0 PHPMailer isn't a mailing list manager!
     */
    public $SingleTo = false;

    /**
     * Storage for addresses when SingleTo is enabled.
     *
     * @var array
     */
    protected $SingleToArray = [];

    /**
     * Whether to generate VERP addresses on send.
     * Only applicable when sending via SMTP.
     *
     * @see https://en.wikipedia.org/wiki/Variable_envelope_return_path
     * @see http://www.postfix.org/VERP_README.html Postfix VERP info
     *
     * @var bool
     */
    public $do_verp = false;

    /**
     * Whether to allow sending messages with an empty body.
     *
     * @var bool
     */
    public $AllowEmpty = false;

    /**
     * DKIM selector.
     *
     * @var string
     */
    public $DKIM_selector = '';

    /**
     * DKIM Identity.
     * Usually the email address used as the source of the email.
     *
     * @var string
     */
    public $DKIM_identity = '';

    /**
     * DKIM passphrase.
     * Used if your key is encrypted.
     *
     * @var string
     */
    public $DKIM_passphrase = '';

    /**
     * DKIM signing domain name.
     *
     * @example 'example.com'
     *
     * @var string
     */
    public $DKIM_domain = '';

    /**
     * DKIM Copy header field values for diagnostic use.
     *
     * @var bool
     */
    public $DKIM_copyHeaderFields = true;

    /**
     * DKIM Extra signing headers.
     *
     * @example ['List-Unsubscribe', 'List-Help']
     *
     * @var array
     */
    public $DKIM_extraHeaders = [];

    /**
     * DKIM private key file path.
     *
     * @var string
     */
    public $DKIM_private = '';

    /**
     * DKIM private key string.
     *
     * If set, takes precedence over `$DKIM_private`.
     *
     * @var string
     */
    public $DKIM_private_string = '';

    /**
     * Callback Action function name.
     *
     * The function that handles the result of the send email action.
     * It is called out by send() for each email sent.
     *
     * Value can be any php callable: http://www.php.net/is_callable
     *
     * Parameters:
     *   bool $result        result of the send action
     *   array   $to            email addresses of the recipients
     *   array   $cc            cc email addresses
     *   array   $bcc           bcc email addresses
     *   string  $subject       the subject
     *   string  $body          the email body
     *   string  $from          email address of sender
     *   string  $extra         extra information of possible use
     *                          "smtp_transaction_id' => last smtp transaction id
     *
     * @var string
     */
    public $action_function = '';

    /**
     * What to put in the X-Mailer header.
     * Options: An empty string for PHPMailer default, whitespace/null for none, or a string to use.
     *
     * @var string|null
     */
    public $XMailer = '';

    /**
     * Which validator to use by default when validating email addresses.
     * May be a callable to inject your own validator, but there are several built-in validators.
     * The default validator uses PHP's FILTER_VALIDATE_EMAIL filter_var option.
     *
     * @see PHPMailer::validateAddress()
     *
     * @var string|callable
     */
    public static $validator = 'php';

    /**
     * An instance of the SMTP sender class.
     *
     * @var SMTP
     */
    protected $smtp;

    /**
     * The array of 'to' names and addresses.
     *
     * @var array
     */
    protected $to = [];

    /**
     * The array of 'cc' names and addresses.
     *
     * @var array
     */
    protected $cc = [];

    /**
     * The array of 'bcc' names and addresses.
     *
     * @var array
     */
    protected $bcc = [];

    /**
     * The array of reply-to names and addresses.
     *
     * @var array
     */
    protected $ReplyTo = [];

    /**
     * An array of all kinds of addresses.
     * Includes all of $to, $cc, $bcc.
     *
     * @see PHPMailer::$to
     * @see PHPMailer::$cc
     * @see PHPMailer::$bcc
     *
     * @var array
     */
    protected $all_recipients = [];

    /**
     * An array of names and addresses queued for validation.
     * In send(), valid and non duplicate entries are moved to $all_recipients
     * and one of $to, $cc, or $bcc.
     * This array is used only for addresses with IDN.
     *
     * @see PHPMailer::$to
     * @see PHPMailer::$cc
     * @see PHPMailer::$bcc
     * @see PHPMailer::$all_recipients
     *
     * @var array
     */
    protected $RecipientsQueue = [];

    /**
     * An array of reply-to names and addresses queued for validation.
     * In send(), valid and non duplicate entries are moved to $ReplyTo.
     * This array is used only for addresses with IDN.
     *
     * @see PHPMailer::$ReplyTo
     *
     * @var array
     */
    protected $ReplyToQueue = [];

    /**
     * The array of attachments.
     *
     * @var array
     */
    protected $attachment = [];

    /**
     * The array of custom headers.
     *
     * @var array
     */
    protected $CustomHeader = [];

    /**
     * The most recent Message-ID (including angular brackets).
     *
     * @var string
     */
    protected $lastMessageID = '';

    /**
     * The message's MIME type.
     *
     * @var string
     */
    protected $message_type = '';

    /**
     * The array of MIME boundary strings.
     *
     * @var array
     */
    protected $boundary = [];

    /**
     * The array of available text strings for the current language.
     *
     * @var array
     */
    protected $language = [];

    /**
     * The number of errors encountered.
     *
     * @var int
     */
    protected $error_count = 0;

    /**
     * The S/MIME certificate file path.
     *
     * @var string
     */
    protected $sign_cert_file = '';

    /**
     * The S/MIME key file path.
     *
     * @var string
     */
    protected $sign_key_file = '';

    /**
     * The optional S/MIME extra certificates ("CA Chain") file path.
     *
     * @var string
     */
    protected $sign_extracerts_file = '';

    /**
     * The S/MIME password for the key.
     * Used only if the key is encrypted.
     *
     * @var string
     */
    protected $sign_key_pass = '';

    /**
     * Whether to throw exceptions for errors.
     *
     * @var bool
     */
    protected $exceptions = false;

    /**
     * Unique ID used for message ID and boundaries.
     *
     * @var string
     */
    protected $uniqueid = '';

    /**
     * The PHPMailer Version number.
     *
     * @var string
     */
    const VERSION = '6.7.1';

    /**
     * Error severity: message only, continue processing.
     *
     * @var int
     */
    const STOP_MESSAGE = 0;

    /**
     * Error severity: message, likely ok to continue processing.
     *
     * @var int
     */
    const STOP_CONTINUE = 1;

    /**
     * Error severity: message, plus full stop, critical error reached.
     *
     * @var int
     */
    const STOP_CRITICAL = 2;

    /**
     * The SMTP standard CRLF line break.
     * If you want to change line break format, change static::$LE, not this.
     */
    const CRLF = "\r\n";

    /**
     * "Folding White Space" a white space string used for line folding.
     */
    const FWS = ' ';

    /**
     * SMTP RFC standard line ending; Carriage Return, Line Feed.
     *
     * @var string
     */
    protected static $LE = self::CRLF;

    /**
     * The maximum line length supported by mail().
     *
     * Background: mail() will sometimes corrupt messages
     * with headers headers longer than 65 chars, see #818.
     *
     * @var int
     */
    const MAIL_MAX_LINE_LENGTH = 63;

    /**
     * The maximum line length allowed by RFC 2822 section 2.1.1.
     *
     * @var int
     */
    const MAX_LINE_LENGTH = 998;

    /**
     * The lower maximum line length allowed by RFC 2822 section 2.1.1.
     * This length does NOT include the line break
     * 76 means that lines will be 77 or 78 chars depending on whether
     * the line break format is LF or CRLF; both are valid.
     *
     * @var int
     */
    const STD_LINE_LENGTH = 76;

    /**
     * Constructor.
     *
     * @param bool $exceptions Should we throw external exceptions?
     */
    public function __construct($exceptions = null)
    {
        if (null !== $exceptions) {
            $this->exceptions = (bool) $exceptions;
        }
        //Pick an appropriate debug output format automatically
        $this->Debugoutput = (strpos(PHP_SAPI, 'cli') !== false ? 'echo' : 'html');
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        //Close any open SMTP connection nicely
        $this->smtpClose();
    }

    /**
     * Call mail() in a safe_mode-aware fashion.
     * Also, unless sendmail_path points to sendmail (or something that
     * claims to be sendmail), don't pass params (not a perfect fix,
     * but it will do).
     *
     * @param string      $to      To
     * @param string      $subject Subject
     * @param string      $body    Message Body
     * @param string      $header  Additional Header(s)
     * @param string|null $params  Params
     *
     * @return bool
     */
    private function mailPassthru($to, $subject, $body, $header, $params)
    {
        //Check overloading of mail function to avoid double-encoding
        if ((int)ini_get('mbstring.func_overload') & 1) {
            $subject = $this->secureHeader($subject);
        } else {
            $subject = $this->encodeHeader($this->secureHeader($subject));
        }
        //Calling mail() with null params breaks
        $this->edebug('Sending with mail()');
        $this->edebug('Sendmail path: ' . ini_get('sendmail_path'));
        $this->edebug("Envelope sender: {$this->Sender}");
        $this->edebug("To: {$to}");
        $this->edebug("Subject: {$subject}");
        $this->edebug("Headers: {$header}");
        if (!$this->UseSendmailOptions || null === $params) {
            $result = @mail($to, $subject, $body, $header);
        } else {
            $this->edebug("Additional params: {$params}");
            $result = @mail($to, $subject, $body, $header, $params);
        }
        $this->edebug('Result: ' . ($result ? 'true' : 'false'));
        return $result;
    }

    /**
     * Output debugging info via a user-defined method.
     * Only generates output if debug output is enabled.
     *
     * @see PHPMailer::$Debugoutput
     * @see PHPMailer::$SMTPDebug
     *
     * @param string $str
     */
    protected function edebug($str)
    {
        if ($this->SMTPDebug <= 0) {
            return;
        }
        //Is this a PSR-3 logger?
        if ($this->Debugoutput instanceof \Psr\Log\LoggerInterface) {
            $this->Debugoutput->debug($str);

            return;
        }
        //Avoid clash with built-in function names
        if (is_callable($this->Debugoutput) && !in_array($this->Debugoutput, ['error_log', 'html', 'echo'])) {
            call_user_func($this->Debugoutput, $str, $this->SMTPDebug);

            return;
        }
        switch ($this->Debugoutput) {
            case 'error_log':
                //Don't output, just log
                /** @noinspection ForgottenDebugOutputInspection */
                error_log($str);
                break;
            case 'html':
                //Cleans up output a bit for a better looking, HTML-safe output
                echo htmlentities(
                    preg_replace('/[\r\n]+/', '', $str),
                    ENT_QUOTES,
                    'UTF-8'
                ), "<br>\n";
                break;
            case 'echo':
            default:
                //Normalize line breaks
                $str = preg_replace('/\r\n|\r/m', "\n", $str);
                echo gmdate('Y-m-d H:i:s'),
                "\t",
                    //Trim trailing space
                trim(
                    //Indent for readability, except for trailing break
                    str_replace(
                        "\n",
                        "\n                   \t                  ",
                        trim($str)
                    )
                ),
                "\n";
        }
    }

    /**
     * Sets message type to HTML or plain.
     *
     * @param bool $isHtml True for HTML mode
     */
    public function isHTML($isHtml = true)
    {
        if ($isHtml) {
            $this->ContentType = static::CONTENT_TYPE_TEXT_HTML;
        } else {
            $this->ContentType = static::CONTENT_TYPE_PLAINTEXT;
        }
    }

    /**
     * Send messages using SMTP.
     */
    public function isSMTP()
    {
        $this->Mailer = 'smtp';
    }

    /**
     * Send messages using PHP's mail() function.
     */
    public function isMail()
    {
        $this->Mailer = 'mail';
    }

    /**
     * Send messages using $Sendmail.
     */
    public function isSendmail()
    {
        $ini_sendmail_path = ini_get('sendmail_path');

        if (false === stripos($ini_sendmail_path, 'sendmail')) {
            $this->Sendmail = '/usr/sbin/sendmail';
        } else {
            $this->Sendmail = $ini_sendmail_path;
        }
        $this->Mailer = 'sendmail';
    }

    /**
     * Send messages using qmail.
     */
    public function isQmail()
    {
        $ini_sendmail_path = ini_get('sendmail_path');

        if (false === stripos($ini_sendmail_path, 'qmail')) {
            $this->Sendmail = '/var/qmail/bin/qmail-inject';
        } else {
            $this->Sendmail = $ini_sendmail_path;
        }
        $this->Mailer = 'qmail';
    }

    /**
     * Add a "To" address.
     *
     * @param string $address The email address to send to
     * @param string $name
     *
     * @throws Exception
     *
     * @return bool true on success, false if address already used or invalid in some way
     */
    public function addAddress($address, $name = '')
    {
        return $this->addOrEnqueueAnAddress('to', $address, $name);
    }

    /**
     * Add a "CC" address.
     *
     * @param string $address The email address to send to
     * @param string $name
     *
     * @throws Exception
     *
     * @return bool true on success, false if address already used or invalid in some way
     */
    public function addCC($address, $name = '')
    {
        return $this->addOrEnqueueAnAddress('cc', $address, $name);
    }

    /**
     * Add a "BCC" address.
     *
     * @param string $address The email address to send to
     * @param string $name
     *
     * @throws Exception
     *
     * @return bool true on success, false if address already used or invalid in some way
     */
    public function addBCC($address, $name = '')
    {
        return $this->addOrEnqueueAnAddress('bcc', $address, $name);
    }

    /**
     * Add a "Reply-To" address.
     *
     * @param string $address The email address to reply to
     * @param string $name
     *
     * @throws Exception
     *
     * @return bool true on success, false if address already used or invalid in some way
     */
    public function addReplyTo($address, $name = '')
    {
        return $this->addOrEnqueueAnAddress('Reply-To', $address, $name);
    }

    /**
     * Add an address to one of the recipient arrays or to the ReplyTo array. Because PHPMailer
     * can't validate addresses with an IDN without knowing the PHPMailer::$CharSet (that can still
     * be modified after calling this function), addition of such addresses is delayed until send().
     * Addresses that have been added already return false, but do not throw exceptions.
     *
     * @param string $kind    One of 'to', 'cc', 'bcc', or 'ReplyTo'
     * @param string $address The email address
     * @param string $name    An optional username associated with the address
     *
     * @throws Exception
     *
     * @return bool true on success, false if address already used or invalid in some way
     */
    protected function addOrEnqueueAnAddress($kind, $address, $name)
    {
        $pos = false;
        if ($address !== null) {
            $address = trim($address);
            $pos = strrpos($address, '@');
        }
        if (false === $pos) {
            //At-sign is missing.
            $error_message = sprintf(
                '%s (%s): %s',
                $this->lang('invalid_address'),
                $kind,
                $address
            );
            $this->setError($error_message);
            $this->edebug($error_message);
            if ($this->exceptions) {
                throw new Exception($error_message);
            }

            return false;
        }
        if ($name !== null && is_string($name)) {
            $name = trim(preg_replace('/[\r\n]+/', '', $name)); //Strip breaks and trim
        } else {
            $name = '';
        }
        $params = [$kind, $address, $name];
        //Enqueue addresses with IDN until we know the PHPMailer::$CharSet.
        //Domain is assumed to be whatever is after the last @ symbol in the address
        if (static::idnSupported() && $this->has8bitChars(substr($address, ++$pos))) {
            if ('Reply-To' !== $kind) {
                if (!array_key_exists($address, $this->RecipientsQueue)) {
                    $this->RecipientsQueue[$address] = $params;

                    return true;
                }
            } elseif (!array_key_exists($address, $this->ReplyToQueue)) {
                $this->ReplyToQueue[$address] = $params;

                return true;
            }

            return false;
        }

        //Immediately add standard addresses without IDN.
        return call_user_func_array([$this, 'addAnAddress'], $params);
    }

    /**
     * Set the boundaries to use for delimiting MIME parts.
     * If you override this, ensure you set all 3 boundaries to unique values.
     * The default boundaries include a "=_" sequence which cannot occur in quoted-printable bodies,
     * as suggested by https://www.rfc-editor.org/rfc/rfc2045#section-6.7
     *
     * @return void
     */
    public function setBoundaries()
    {
        $this->uniqueid = $this->generateId();
        $this->boundary[1] = 'b1=_' . $this->uniqueid;
        $this->boundary[2] = 'b2=_' . $this->uniqueid;
        $this->boundary[3] = 'b3=_' . $this->uniqueid;
    }

    /**
     * Add an address to one of the recipient arrays or to the ReplyTo array.
     * Addresses that have been added already return false, but do not throw exceptions.
     *
     * @param string $kind    One of 'to', 'cc', 'bcc', or 'ReplyTo'
     * @param string $address The email address to send, resp. to reply to
     * @param string $name
     *
     * @throws Exception
     *
     * @return bool true on success, false if address already used or invalid in some way
     */
    protected function addAnAddress($kind, $address, $name = '')
    {
        if (!in_array($kind, ['to', 'cc', 'bcc', 'Reply-To'])) {
            $error_message = sprintf(
                '%s: %s',
                $this->lang('Invalid recipient kind'),
                $kind
            );
            $this->setError($error_message);
            $this->edebug($error_message);
            if ($this->exceptions) {
                throw new Exception($error_message);
            }

            return false;
        }
        if (!static::validateAddress($address)) {
            $error_message = sprintf(
                '%s (%s): %s',
                $this->lang('invalid_address'),
                $kind,
                $address
            );
            $this->setError($error_message);
            $this->edebug($error_message);
            if ($this->exceptions) {
                throw new Exception($error_message);
            }

            return false;
        }
        if ('Reply-To' !== $kind) {
            if (!array_key_exists(strtolower($address), $this->all_recipients)) {
                $this->{$kind}[] = [$address, $name];
                $this->all_recipients[strtolower($address)] = true;

                return true;
            }
        } elseif (!array_key_exists(strtolower($address), $this->ReplyTo)) {
            $this->ReplyTo[strtolower($address)] = [$address, $name];

            return true;
        }

        return false;
    }

    /**
     * Parse and validate a string containing one or more RFC822-style comma-separated email addresses
     * of the form "display name <address>" into an array of name/address pairs.
     * Uses the imap_rfc822_parse_adrlist function if the IMAP extension is available.
     * Note that quotes in the name part are removed.
     *
     * @see http://www.andrew.cmu.edu/user/agreen1/testing/mrbs/web/Mail/RFC822.php A more careful implementation
     *
     * @param string $addrstr The address list string
     * @param bool   $useimap Whether to use the IMAP extension to parse the list
     * @param string $charset The charset to use when decoding the address list string.
     *
     * @return array
     */
    public static function parseAddresses($addrstr, $useimap = true, $charset = self::CHARSET_ISO88591)
    {
        $addresses = [];
        if ($useimap && function_exists('imap_rfc822_parse_adrlist')) {
            //Use this built-in parser if it's available
            $list = imap_rfc822_parse_adrlist($addrstr, '');
            // Clear any potential IMAP errors to get rid of notices being thrown at end of script.
            imap_errors();
            foreach ($list as $address) {
                if (
                    '.SYNTAX-ERROR.' !== $address->host &&
                    static::validateAddress($address->mailbox . '@' . $address->host)
                ) {
                    //Decode the name part if it's present and encoded
                    if (
                        property_exists($address, 'personal') &&
                        //Check for a Mbstring constant rather than using extension_loaded, which is sometimes disabled
                        defined('MB_CASE_UPPER') &&
                        preg_match('/^=\?.*\?=$/s', $address->personal)
                    ) {
                        $origCharset = mb_internal_encoding();
                        mb_internal_encoding($charset);
                        //Undo any RFC2047-encoded spaces-as-underscores
                        $address->personal = str_replace('_', '=20', $address->personal);
                        //Decode the name
                        $address->personal = mb_decode_mimeheader($address->personal);
                        mb_internal_encoding($origCharset);
                    }

                    $addresses[] = [
                        'name' => (property_exists($address, 'personal') ? $address->personal : ''),
                        'address' => $address->mailbox . '@' . $address->host,
                    ];
                }
            }
        } else {
            //Use this simpler parser
            $list = explode(',', $addrstr);
            foreach ($list as $address) {
                $address = trim($address);
                //Is there a separate name part?
                if (strpos($address, '<') === false) {
                    //No separate name, just use the whole thing
                    if (static::validateAddress($address)) {
                        $addresses[] = [
                            'name' => '',
                            'address' => $address,
                        ];
                    }
                } else {
                    list($name, $email) = explode('<', $address);
                    $email = trim(str_replace('>', '', $email));
                    $name = trim($name);
                    if (static::validateAddress($email)) {
                        //Check for a Mbstring constant rather than using extension_loaded, which is sometimes disabled
                        //If this name is encoded, decode it
                        if (defined('MB_CASE_UPPER') && preg_match('/^=\?.*\?=$/s', $name)) {
                            $origCharset = mb_internal_encoding();
                            mb_internal_encoding($charset);
                            //Undo any RFC2047-encoded spaces-as-underscores
                            $name = str_replace('_', '=20', $name);
                            //Decode the name
                            $name = mb_decode_mimeheader($name);
                            mb_internal_encoding($origCharset);
                        }
                        $addresses[] = [
                            //Remove any surrounding quotes and spaces from the name
                            'name' => trim($name, '\'" '),
                            'address' => $email,
                        ];
                    }
                }
            }
        }

        return $addresses;
    }

    /**
     * Set the From and FromName properties.
     *
     * @param string $address
     * @param string $name
     * @param bool   $auto    Whether to also set the Sender address, defaults to true
     *
     * @throws Exception
     *
     * @return bool
     */
    public function setFrom($address, $name = '', $auto = true)
    {
        $address = trim((string)$address);
        $name = trim(preg_replace('/[\r\n]+/', '', $name)); //Strip breaks and trim
        //Don't validate now addresses with IDN. Will be done in send().
        $pos = strrpos($address, '@');
        if (
            (false === $pos)
            || ((!$this->has8bitChars(substr($address, ++$pos)) || !static::idnSupported())
            && !static::validateAddress($address))
        ) {
            $error_message = sprintf(
                '%s (From): %s',
                $this->lang('invalid_address'),
                $address
            );
            $this->setError($error_message);
            $this->edebug($error_message);
            if ($this->exceptions) {
                throw new Exception($error_message);
            }

            return false;
        }
        $this->From = $address;
        $this->FromName = $name;
        if ($auto && empty($this->Sender)) {
            $this->Sender = $address;
        }

        return true;
    }

    /**
     * Return the Message-ID header of the last email.
     * Technically this is the value from the last time the headers were created,
     * but it's also the message ID of the last sent message except in
     * pathological cases.
     *
     * @return string
     */
    public function getLastMessageID()
    {
        return $this->lastMessageID;
    }

    /**
     * Check that a string looks like an email address.
     * Validation patterns supported:
     * * `auto` Pick best pattern automatically;
     * * `pcre8` Use the squiloople.com pattern, requires PCRE > 8.0;
     * * `pcre` Use old PCRE implementation;
     * * `php` Use PHP built-in FILTER_VALIDATE_EMAIL;
     * * `html5` Use the pattern given by the HTML5 spec for 'email' type form input elements.
     * * `noregex` Don't use a regex: super fast, really dumb.
     * Alternatively you may pass in a callable to inject your own validator, for example:
     *
     * ```php
     * PHPMailer::validateAddress('user@example.com', function($address) {
     *     return (strpos($address, '@') !== false);
     * });
     * ```
     *
     * You can also set the PHPMailer::$validator static to a callable, allowing built-in methods to use your validator.
     *
     * @param string          $address       The email address to check
     * @param string|callable $patternselect Which pattern to use
     *
     * @return bool
     */
    public static function validateAddress($address, $patternselect = null)
    {
        if (null === $patternselect) {
            $patternselect = static::$validator;
        }
        //Don't allow strings as callables, see SECURITY.md and CVE-2021-3603
        if (is_callable($patternselect) && !is_string($patternselect)) {
            return call_user_func($patternselect, $address);
        }
        //Reject line breaks in addresses; it's valid RFC5322, but not RFC5321
        if (strpos($address, "\n") !== false || strpos($address, "\r") !== false) {
            return false;
        }
        switch ($patternselect) {
            case 'pcre': //Kept for BC
            case 'pcre8':
                /*
                 * A more complex and more permissive version of the RFC5322 regex on which FILTER_VALIDATE_EMAIL
                 * is based.
                 * In addition to the addresses allowed by filter_var, also permits:
                 *  * dotless domains: `a@b`
                 *  * comments: `1234 @ local(blah) .machine .example`
                 *  * quoted elements: `'"test blah"@example.org'`
                 *  * numeric TLDs: `a@b.123`
                 *  * unbracketed IPv4 literals: `a@192.168.0.1`
                 *  * IPv6 literals: 'first.last@[IPv6:a1::]'
                 * Not all of these will necessarily work for sending!
                 *
                 * @see       http://squiloople.com/2009/12/20/email-address-validation/
                 * @copyright 2009-2010 Michael Rushton
                 * Feel free to use and redistribute this code. But please keep this copyright notice.
                 */
                return (bool) preg_match(
                    '/^(?!(?>(?1)"?(?>\\\[ -~]|[^"])"?(?1)){255,})(?!(?>(?1)"?(?>\\\[ -~]|[^"])"?(?1)){65,}@)' .
                    '((?>(?>(?>((?>(?>(?>\x0D\x0A)?[\t ])+|(?>[\t ]*\x0D\x0A)?[\t ]+)?)(\((?>(?2)' .
                    '(?>[\x01-\x08\x0B\x0C\x0E-\'*-\[\]-\x7F]|\\\[\x00-\x7F]|(?3)))*(?2)\)))+(?2))|(?2))?)' .
                    '([!#-\'*+\/-9=?^-~-]+|"(?>(?2)(?>[\x01-\x08\x0B\x0C\x0E-!#-\[\]-\x7F]|\\\[\x00-\x7F]))*' .
                    '(?2)")(?>(?1)\.(?1)(?4))*(?1)@(?!(?1)[a-z0-9-]{64,})(?1)(?>([a-z0-9](?>[a-z0-9-]*[a-z0-9])?)' .
                    '(?>(?1)\.(?!(?1)[a-z0-9-]{64,})(?1)(?5)){0,126}|\[(?:(?>IPv6:(?>([a-f0-9]{1,4})(?>:(?6)){7}' .
                    '|(?!(?:.*[a-f0-9][:\]]){8,})((?6)(?>:(?6)){0,6})?::(?7)?))|(?>(?>IPv6:(?>(?6)(?>:(?6)){5}:' .
                    '|(?!(?:.*[a-f0-9]:){6,})(?8)?::(?>((?6)(?>:(?6)){0,4}):)?))?(25[0-5]|2[0-4][0-9]|1[0-9]{2}' .
                    '|[1-9]?[0-9])(?>\.(?9)){3}))\])(?1)$/isD',
                    $address
                );
            case 'html5':
                /*
                 * This is the pattern used in the HTML5 spec for validation of 'email' type form input elements.
                 *
                 * @see https://html.spec.whatwg.org/#e-mail-state-(type=email)
                 */
                return (bool) preg_match(
                    '/^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}' .
                    '[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/sD',
                    $address
                );
            case 'php':
            default:
                return filter_var($address, FILTER_VALIDATE_EMAIL) !== false;
        }
    }

    /**
     * Tells whether IDNs (Internationalized Domain Names) are supported or not. This requires the
     * `intl` and `mbstring` PHP extensions.
     *
     * @return bool `true` if required functions for IDN support are present
     */
    public static function idnSupported()
    {
        return function_exists('idn_to_ascii') && function_exists('mb_convert_encoding');
    }

    /**
     * Converts IDN in given email address to its ASCII form, also known as punycode, if possible.
     * Important: Address must be passed in same encoding as currently set in PHPMailer::$CharSet.
     * This function silently returns unmodified address if:
     * - No conversion is necessary (i.e. domain name is not an IDN, or is already in ASCII form)
     * - Conversion to punycode is impossible (e.g. required PHP functions are not available)
     *   or fails for any reason (e.g. domain contains characters not allowed in an IDN).
     *
     * @see PHPMailer::$CharSet
     *
     * @param string $address The email address to convert
     *
     * @return string The encoded address in ASCII form
     */
    public function punyencodeAddress($address)
    {
        //Verify we have required functions, CharSet, and at-sign.
        $pos = strrpos($address, '@');
        if (
            !empty($this->CharSet) &&
            false !== $pos &&
            static::idnSupported()
        ) {
            $domain = substr($address, ++$pos);
            //Verify CharSet string is a valid one, and domain properly encoded in this CharSet.
            if ($this->has8bitChars($domain) && @mb_check_encoding($domain, $this->CharSet)) {
                //Convert the domain from whatever charset it's in to UTF-8
                $domain = mb_convert_encoding($domain, self::CHARSET_UTF8, $this->CharSet);
                //Ignore IDE complaints about this line - method signature changed in PHP 5.4
                $errorcode = 0;
                if (defined('INTL_IDNA_VARIANT_UTS46')) {
                    //Use the current punycode standard (appeared in PHP 7.2)
                    $punycode = idn_to_ascii(
                        $domain,
                        \IDNA_DEFAULT | \IDNA_USE_STD3_RULES | \IDNA_CHECK_BIDI |
                            \IDNA_CHECK_CONTEXTJ | \IDNA_NONTRANSITIONAL_TO_ASCII,
                        \INTL_IDNA_VARIANT_UTS46
                    );
                } elseif (defined('INTL_IDNA_VARIANT_2003')) {
                    //Fall back to this old, deprecated/removed encoding
                    $punycode = idn_to_ascii($domain, $errorcode, \INTL_IDNA_VARIANT_2003);
                } else {
                    //Fall back to a default we don't know about
                    $punycode = idn_to_ascii($domain, $errorcode);
                }
                if (false !== $punycode) {
                    return substr($address, 0, $pos) . $punycode;
                }
            }
        }

        return $address;
    }

    /**
     * Create a message and send it.
     * Uses the sending method specified by $Mailer.
     *
     * @throws Exception
     *
     * @return bool false on error - See the ErrorInfo property for details of the error
     */
    public function send()
    {
        try {
            if (!$this->preSend()) {
                return false;
            }

            return $this->postSend();
        } catch (Exception $exc) {
            $this->mailHeader = '';
            $this->setError($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return false;
        }
    }

    /**
     * Prepare a message for sending.
     *
     * @throws Exception
     *
     * @return bool
     */
    public function preSend()
    {
        if (
            'smtp' === $this->Mailer
            || ('mail' === $this->Mailer && (\PHP_VERSION_ID >= 80000 || stripos(PHP_OS, 'WIN') === 0))
        ) {
            //SMTP mandates RFC-compliant line endings
            //and it's also used with mail() on Windows
            static::setLE(self::CRLF);
        } else {
            //Maintain backward compatibility with legacy Linux command line mailers
            static::setLE(PHP_EOL);
        }
        //Check for buggy PHP versions that add a header with an incorrect line break
        if (
            'mail' === $this->Mailer
            && ((\PHP_VERSION_ID >= 70000 && \PHP_VERSION_ID < 70017)
                || (\PHP_VERSION_ID >= 70100 && \PHP_VERSION_ID < 70103))
            && ini_get('mail.add_x_header') === '1'
            && stripos(PHP_OS, 'WIN') === 0
        ) {
            trigger_error($this->lang('buggy_php'), E_USER_WARNING);
        }

        try {
            $this->error_count = 0; //Reset errors
            $this->mailHeader = '';

            //Dequeue recipient and Reply-To addresses with IDN
            foreach (array_merge($this->RecipientsQueue, $this->ReplyToQueue) as $params) {
                $params[1] = $this->punyencodeAddress($params[1]);
                call_user_func_array([$this, 'addAnAddress'], $params);
            }
            if (count($this->to) + count($this->cc) + count($this->bcc) < 1) {
                throw new Exception($this->lang('provide_address'), self::STOP_CRITICAL);
            }

            //Validate From, Sender, and ConfirmReadingTo addresses
            foreach (['From', 'Sender', 'ConfirmReadingTo'] as $address_kind) {
                $this->{$address_kind} = trim($this->{$address_kind});
                if (empty($this->{$address_kind})) {
                    continue;
                }
                $this->{$address_kind} = $this->punyencodeAddress($this->{$address_kind});
                if (!static::validateAddress($this->{$address_kind})) {
                    $error_message = sprintf(
                        '%s (%s): %s',
                        $this->lang('invalid_address'),
                        $address_kind,
                        $this->{$address_kind}
                    );
                    $this->setError($error_message);
                    $this->edebug($error_message);
                    if ($this->exceptions) {
                        throw new Exception($error_message);
                    }

                    return false;
                }
            }

            //Set whether the message is multipart/alternative
            if ($this->alternativeExists()) {
                $this->ContentType = static::CONTENT_TYPE_MULTIPART_ALTERNATIVE;
            }

            $this->setMessageType();
            //Refuse to send an empty message unless we are specifically allowing it
            if (!$this->AllowEmpty && empty($this->Body)) {
                throw new Exception($this->lang('empty_message'), self::STOP_CRITICAL);
            }

            //Trim subject consistently
            $this->Subject = trim($this->Subject);
            //Create body before headers in case body makes changes to headers (e.g. altering transfer encoding)
            $this->MIMEHeader = '';
            $this->MIMEBody = $this->createBody();
            //createBody may have added some headers, so retain them
            $tempheaders = $this->MIMEHeader;
            $this->MIMEHeader = $this->createHeader();
            $this->MIMEHeader .= $tempheaders;

            //To capture the complete message when using mail(), create
            //an extra header list which createHeader() doesn't fold in
            if ('mail' === $this->Mailer) {
                if (count($this->to) > 0) {
                    $this->mailHeader .= $this->addrAppend('To', $this->to);
                } else {
                    $this->mailHeader .= $this->headerLine('To', 'undisclosed-recipients:;');
                }
                $this->mailHeader .= $this->headerLine(
                    'Subject',
                    $this->encodeHeader($this->secureHeader($this->Subject))
                );
            }

            //Sign with DKIM if enabled
            if (
                !empty($this->DKIM_domain)
                && !empty($this->DKIM_selector)
                && (!empty($this->DKIM_private_string)
                    || (!empty($this->DKIM_private)
                        && static::isPermittedPath($this->DKIM_private)
                        && file_exists($this->DKIM_private)
                    )
                )
            ) {
                $header_dkim = $this->DKIM_Add(
                    $this->MIMEHeader . $this->mailHeader,
                    $this->encodeHeader($this->secureHeader($this->Subject)),
                    $this->MIMEBody
                );
                $this->MIMEHeader = static::stripTrailingWSP($this->MIMEHeader) . static::$LE .
                    static::normalizeBreaks($header_dkim) . static::$LE;
            }

            return true;
        } catch (Exception $exc) {
            $this->setError($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return false;
        }
    }

    /**
     * Actually send a message via the selected mechanism.
     *
     * @throws Exception
     *
     * @return bool
     */
    public function postSend()
    {
        try {
            //Choose the mailer and send through it
            switch ($this->Mailer) {
                case 'sendmail':
                case 'qmail':
                    return $this->sendmailSend($this->MIMEHeader, $this->MIMEBody);
                case 'smtp':
                    return $this->smtpSend($this->MIMEHeader, $this->MIMEBody);
                case 'mail':
                    return $this->mailSend($this->MIMEHeader, $this->MIMEBody);
                default:
                    $sendMethod = $this->Mailer . 'Send';
                    if (method_exists($this, $sendMethod)) {
                        return $this->{$sendMethod}($this->MIMEHeader, $this->MIMEBody);
                    }

                    return $this->mailSend($this->MIMEHeader, $this->MIMEBody);
            }
        } catch (Exception $exc) {
            $this->setError($exc->getMessage());
            $this->edebug($exc->getMessage());
            if ($this->Mailer === 'smtp' && $this->SMTPKeepAlive == true && $this->smtp->connected()) {
                $this->smtp->reset();
            }
            if ($this->exceptions) {
                throw $exc;
            }
        }

        return false;
    }

    /**
     * Send mail using the $Sendmail program.
     *
     * @see PHPMailer::$Sendmail
     *
     * @param string $header The message headers
     * @param string $body   The message body
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function sendmailSend($header, $body)
    {
        if ($this->Mailer === 'qmail') {
            $this->edebug('Sending with qmail');
        } else {
            $this->edebug('Sending with sendmail');
        }
        $header = static::stripTrailingWSP($header) . static::$LE . static::$LE;
        //This sets the SMTP envelope sender which gets turned into a return-path header by the receiver
        //A space after `-f` is optional, but there is a long history of its presence
        //causing problems, so we don't use one
        //Exim docs: http://www.exim.org/exim-html-current/doc/html/spec_html/ch-the_exim_command_line.html
        //Sendmail docs: http://www.sendmail.org/~ca/email/man/sendmail.html
        //Qmail docs: http://www.qmail.org/man/man8/qmail-inject.html
        //Example problem: https://www.drupal.org/node/1057954

        //PHP 5.6 workaround
        $sendmail_from_value = ini_get('sendmail_from');
        if (empty($this->Sender) && !empty($sendmail_from_value)) {
            //PHP config has a sender address we can use
            $this->Sender = ini_get('sendmail_from');
        }
        //CVE-2016-10033, CVE-2016-10045: Don't pass -f if characters will be escaped.
        if (!empty($this->Sender) && static::validateAddress($this->Sender) && self::isShellSafe($this->Sender)) {
            if ($this->Mailer === 'qmail') {
                $sendmailFmt = '%s -f%s';
            } else {
                $sendmailFmt = '%s -oi -f%s -t';
            }
        } else {
            //allow sendmail to choose a default envelope sender. It may
            //seem preferable to force it to use the From header as with
            //SMTP, but that introduces new problems (see
            //<https://github.com/PHPMailer/PHPMailer/issues/2298>), and
            //it has historically worked this way.
            $sendmailFmt = '%s -oi -t';
        }

        $sendmail = sprintf($sendmailFmt, escapeshellcmd($this->Sendmail), $this->Sender);
        $this->edebug('Sendmail path: ' . $this->Sendmail);
        $this->edebug('Sendmail command: ' . $sendmail);
        $this->edebug('Envelope sender: ' . $this->Sender);
        $this->edebug("Headers: {$header}");

        if ($this->SingleTo) {
            foreach ($this->SingleToArray as $toAddr) {
                $mail = @popen($sendmail, 'w');
                if (!$mail) {
                    throw new Exception($this->lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
                }
                $this->edebug("To: {$toAddr}");
                fwrite($mail, 'To: ' . $toAddr . "\n");
                fwrite($mail, $header);
                fwrite($mail, $body);
                $result = pclose($mail);
                $addrinfo = static::parseAddresses($toAddr, true, $this->CharSet);
                $this->doCallback(
                    ($result === 0),
                    [[$addrinfo['address'], $addrinfo['name']]],
                    $this->cc,
                    $this->bcc,
                    $this->Subject,
                    $body,
                    $this->From,
                    []
                );
                $this->edebug("Result: " . ($result === 0 ? 'true' : 'false'));
                if (0 !== $result) {
                    throw new Exception($this->lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
                }
            }
        } else {
            $mail = @popen($sendmail, 'w');
            if (!$mail) {
                throw new Exception($this->lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
            }
            fwrite($mail, $header);
            fwrite($mail, $body);
            $result = pclose($mail);
            $this->doCallback(
                ($result === 0),
                $this->to,
                $this->cc,
                $this->bcc,
                $this->Subject,
                $body,
                $this->From,
                []
            );
            $this->edebug("Result: " . ($result === 0 ? 'true' : 'false'));
            if (0 !== $result) {
                throw new Exception($this->lang('execute') . $this->Sendmail, self::STOP_CRITICAL);
            }
        }

        return true;
    }

    /**
     * Fix CVE-2016-10033 and CVE-2016-10045 by disallowing potentially unsafe shell characters.
     * Note that escapeshellarg and escapeshellcmd are inadequate for our purposes, especially on Windows.
     *
     * @see https://github.com/PHPMailer/PHPMailer/issues/924 CVE-2016-10045 bug report
     *
     * @param string $string The string to be validated
     *
     * @return bool
     */
    protected static function isShellSafe($string)
    {
        //It's not possible to use shell commands safely (which includes the mail() function) without escapeshellarg,
        //but some hosting providers disable it, creating a security problem that we don't want to have to deal with,
        //so we don't.
        if (!function_exists('escapeshellarg') || !function_exists('escapeshellcmd')) {
            return false;
        }

        if (
            escapeshellcmd($string) !== $string
            || !in_array(escapeshellarg($string), ["'$string'", "\"$string\""])
        ) {
            return false;
        }

        $length = strlen($string);

        for ($i = 0; $i < $length; ++$i) {
            $c = $string[$i];

            //All other characters have a special meaning in at least one common shell, including = and +.
            //Full stop (.) has a special meaning in cmd.exe, but its impact should be negligible here.
            //Note that this does permit non-Latin alphanumeric characters based on the current locale.
            if (!ctype_alnum($c) && strpos('@_-.', $c) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check whether a file path is of a permitted type.
     * Used to reject URLs and phar files from functions that access local file paths,
     * such as addAttachment.
     *
     * @param string $path A relative or absolute path to a file
     *
     * @return bool
     */
    protected static function isPermittedPath($path)
    {
        //Matches scheme definition from https://tools.ietf.org/html/rfc3986#section-3.1
        return !preg_match('#^[a-z][a-z\d+.-]*://#i', $path);
    }

    /**
     * Check whether a file path is safe, accessible, and readable.
     *
     * @param string $path A relative or absolute path to a file
     *
     * @return bool
     */
    protected static function fileIsAccessible($path)
    {
        if (!static::isPermittedPath($path)) {
            return false;
        }
        $readable = is_file($path);
        //If not a UNC path (expected to start with \\), check read permission, see #2069
        if (strpos($path, '\\\\') !== 0) {
            $readable = $readable && is_readable($path);
        }
        return  $readable;
    }

    /**
     * Send mail using the PHP mail() function.
     *
     * @see http://www.php.net/manual/en/book.mail.php
     *
     * @param string $header The message headers
     * @param string $body   The message body
     *
     * @throws Exception
     *
     * @return bool
     */
    protected function mailSend($header, $body)
    {
        $header = static::stripTrailingWSP($header) . static::$LE . static::$LE;

        $toArr = [];
        foreach ($this->to as $toaddr) {
            $toArr[] = $this->addrFormat($toaddr);
        }
        $to = trim(implode(', ', $toArr));

        //If there are no To-addresses (e.g. when sending only to BCC-addresses)
        //the following should be added to get a correct DKIM-signature.
        //Compare with $this->preSend()
        if ($to === '') {
            $to = 'undisclosed-recipients:;';
        }

        $params = null;
        //This sets the SMTP envelope sender which gets turned into a return-path header by the receiver
        //A space after `-f` is optional, but there is a long history of its presence
        //causing problems, so we don't use one
        //Exim docs: http://www.exim.org/exim-html-current/doc/html/spec_html/ch-the_exim_command_line.html
        //Sendmail docs: http://www.sendmail.org/~ca/email/man/sendmail.html
        //Qmail docs: http://www.qmail.org/man/man8/qmail-inject.html
        //Example problem: https://www.drupal.org/node/1057954
        //CVE-2016-10033, CVE-2016-10045: Don't pass -f if characters will be escaped.

        //PHP 5.6 workaround
        $sendmail_from_value = ini_get('sendmail_from');
        if (empty($this->Sender) && !empty($sendmail_from_value)) {
            //PHP config has a sender address we can use
            $this->Sender = ini_get('sendmail_from');
        }
        if (!empty($this->Sender) && static::validateAddress($this->Sender)) {
            if (self::isShellSafe($this->Sender)) {
                $params = sprintf('-f%s', $this->Sender);
            }
            $old_from = ini_get('sendmail_from');
            ini_set('sendmail_from', $this->Sender);
        }
        $result = false;
        if ($this->SingleTo && count("toArs) >"0)({  %$        vkreacj ($tÔArr ls $toAddr) {
   † 0 †    †$ 02esuld = &this->mAilPasst`ru $tÔA$dr, $this->S5fjeat$0$fodyl $header,!,qarqms);
           (    $iddrYnno =2staticz:parsmIp`reÛses(,to¡tdr, tvUe,h§thIs->CharSet(;
          !     $thi3->doCam|bcck(
  $        `"  (   `,resunt,
 0`(       ` !   ! [_$addrinfo$address'], $addrinFg€'famg'U_],
0$  †    0   †      $uhhsm>cc,
 `          h°  Ä `,$txiS->`cc,
    (`! !! `†0     1$this->St"ject4
                   dbol{,
  "p      $   "$   !$tHas->Frmm,   0 "!" b         Z]
2   (           ©;
 (  $       }
 ` 0`   } else {
 "      $  &,rerult }$¥Th)s->makÏPdssthru($to, $tliw≠>”ubject- $bodY, $head$r  pAramÛ(;*   $ 4 †  0`$this->doCqllbackhdrgsult, $this->to,$$thIs>cc( $this/>Bcc,  vhiw-.Subjekt,0$body) $t(iw->From, []+;
    †00 ˝
      ) if  isset($old_frmm)) {
 $    (  †  inÏ_set(g{endmail_fvoi'"$olf_nroo);
`       }
 (      iÊ !$rusult) {
 `  ($!  0  virow New ExcÂrtion($thi3->lale(#instaŒtk·te'-, seln>:STOP_CRAT…CAD){
   $    }
! %† `  2eturn true;
  † ]
    /**ä  $  * GOt an inwÙance Ùo use foÚ SMTR operatiÔn#>
   ` ) Override tËis fwnction po lo!e˘kur own SMTP†imxlm}entation,*     "or sAt†one with SetS]TPInstcnca.
 $   *J  (  * @rE4upn SMUQä     */+    publia†fuNctimn ge4SMT–Inwtance()* ` 0{
"      0if (!is_object(6this%>smtp)( {
  †  †  ¢  4thÈs≠>{-tp"- new0SMTQ();
  †    †y
™  !   "return ,thys->rmtp;
    }

 " $/**
     * pro4ide An iÓkdanca tk use nor!SETP!operathons.
   0 *  ( †* @zd4qrÓ SMTQ    `*/
   †public Êunctio. smtSMTPInstencu8SMTQ $Smtp)J    {
    †   $thi3-smtp 9 $rmtp;
        !rEtusn $this->smtt;
 $  }

0  $/**  2 $* Send mail2fi# Wm‘Q.
 `   :!Rmdurns valsd if theru is a bad MAIL FVOM.!CPT, or DATA inqut.
     *
     * @see PHPaiher::ÛetSM‘PInrLance() to†use a dif&erent adas{.
     +J   † * @usus \RHPI·ildr\p@P]ailer]SmTP
    $+
     * @pizam sTring diea‰er »u†mesÛage hea$Ers
    !*  parAm†wtring &sody   ie mess·ge body     *
     * @t`rows Exceptioj
     **† ! `( @redur/ cooh
   0 */
  ! `rtEcted funcvmon qmdpSeld©$headeˆ, tbody)
)   {J ! 0    $hTader = {tatiC::striPtrailingWP(4headEv) . st¡tic:$LE . stAtic::%^≈;
   $    $bad_rcpt = [];
   †    if (!4thi2->sm4qConÓekt(,thÈs-6TPO<ions)+`{ 0          throw f%w Exception($dhys/>la˛g('3mvp_cgÊnect_Êai,ut'), {elfz:StOPCRITICa\);	   "    }
  0     //Stnddr already valid!ted in PruC)nd®)
!` † 0  if`(%'†<}9 $|his->SenDeb) ˚
      (     &smtpWfroM - $|his->From;*        } else"{       §  " %Qmtp^from = $thi3->Send%r?      h }J        if )!%Tlis-6ql4,>makl(eymtp_from)) 
0   †     0 $vhis-setEpxor<%vhis/>nqng('from_dailed'- . $˚mpp_f˙om &!'!: ' . implode('-7, $tËis->wmtp5>getGrrz(©+);ä    "" †    thÚow1new ExgePtinn0$thir-~ErrovHnfo, welf∫:STOPRITICQL);
 `2     }
†  !     callbccks Ω ];
    0   /?¡tpe}rt to!send uo all recÈpiejtw     (  foreaah`8[$this->tÔ, $4his-?cc,$$this->bcc] as 4togqoqp) {
         ( $Forgakh (,togrnup a30&to)b
               `if0*!,thIs-æsmtp->r%cipient(%to[0- $uh)s/>dsn))#{
    "   †   `  ) "  $error =†$this->smpp-:ge4≈rror );
       (            $badKrcpt_] = ['to'†=û $toﬂ1U( 'eÚrkr' => $eÚror['devaalg];   !          `     ,is[ent - fc,se{
     $†   8"  ( } else {
 0 !  ``    !†   `  $isSe~t"< true;
 %  †  `!     " }
 (   `         0$aaldbEcis[]"- ['irsent'`=> $isSelt, 'to' =Æ $uo[0], 'name' => $to[1M];
  $ *† †    =
$! ! !( u
 "   (  /ÆOndy sq~‰ the DAA cOllant(in ˜e have1via`le reKixiejt{
  "!  !`if ®(couft(this->iÏlWRekipienvs)!> aoun4($`ad]rcp))`&& ! thhs)>smtp->data($lecd`r .0$jmdi))a[
0(     ¢† $ thr◊ new A|g%P4yon8$this->lang('$ata_ngu_ac„gpte$'), seLb::STO–C“YTICAL);J        }

 ( 0   $Ûmvp_tza.saktion_id =0$t`ic%6smtp/.getLaStTÚans!ctionID(9;

    `   if 8$thIs->SMTPKeapAÏive)!{
 †      †`" $this,:{mtx)>Reset8);
       "} else {
 ` †0† $   0$dlis->smtp->quit );
           !$th)s->3htp->close(°;
  $     y™ † `    gopEcch ($ccllba„ks ·w $cb- {
 0 %        dt(ys->doCalLback
0"     *   † †0†$kb['i”sant'X,
 0       (      [[$cb['to], $c`{ßnae']M],
    $   (†    ( Z](
"        "      []
 `$        !  ° $4his->Subje#4l                ,body,J   †     "      fdhis->From,*    $  !    ! 0 ['smDp_tr`nraction_id' =>  smtpOtransaCtiof_Id]    )       );
  †  (  }
    ® " ?/Creqde(error(mess`gE fo2!·ny0bad(addresses
  `  0  )f (coun|(§bad_rgpÙ) > 0) {*   `        errq4r = #'9
     `"     gkreach ($bad_pcpt es &b·d);J     0(         $mrrstr`.= $bm`#to']",!': '0. $bad€'error'];
            
†"     (    throw new Excgpdion(%Ùhis/>lang('recirignts_fiimed'x .`$errspr, wdlÊ:STOP_¬O∆DINQA)≥
` ` 0   ]† "0 ( !rat5rn true;
    }
*    /™*
  †( * Initiate a „onnecuIo. to an SMTP sepder. †   ™ Retqplr false if the o`eratÈnn faiLed.J  0  *
     . @param avray $oppyons An array o& Options0coÌpatible with0streÒm_con|Ext_creite	)ä    $
†    .†@|hrows Exgeption
  ! $*
     * @ıses`\PIPMailmr\PHPMa)ler\QMTP
  (  *
$  ` : @rdÙern b/oÏ     */
   0public∞funatigÓ smtpConngc|($nrÙion{$= ounl9
    {
    !   in (uLl ===  Ùhmq->smtp),{
†         "!$this-?smtp = $this)>ge|SMTPIfsTalce();   †  " }
     `( //)d no"optIonc`ar% provided,0urg uhaÙever is"set(in the instAnce
        if (null <== $option- ; a $0 " )   $opti~ns = $t*is->SMTPOptions;
 (    0"}

        //Elruadq conneatÂd?
     $ biÊ ($|Ëis-?smtp≠>ronnecfed())"{Ä !       ( beturo 4Rue;
   "    
   &`  !$tlis->smt0=>sevTImecut($ThiÛ%>Ti}Eoud);
`       $this->smtb->CetDe‚ugLevmlh$th)s-”LTPDefug);*    ∞   $this%?3mtp>sdtD%bugOutput($u(is->Debugoutput);
        $thiÛ->smdp->setevp(%vhi3/>d_vez`+
  †  0 $if$*$|iis->@oq|`===0nyfÓ)£{
  $  0     ($t(i3≠7Lost =0'loc`¸host{
  !   ` =
        !hosts = dxplole(';', $4hir->Hgst);
 †"!    $laste¯ception†= null;

(       gmreacH ($josts a{ $hosdeot2˘)≤{  †      (†0$hostinfo  K]y$     †     if (
   " †( 0       !pregﬂmatch(
 0      †  `        'è^*?:(wql4tls):‹/\/+>8nk>)(?::(\d))?$'¨
     `0          †  |bim($hjctuntry)(    "    `    )     jorti.fg
      ("       `)
      $     ) {
    " †   †     $tHms->edebtg($this->|ang(ginvelil_hestentry')  & '`. tsim($hostenur{));                //NOt a$valid hosÙ endry *              contynum;
         (  
`     (d    //&aostinfk[1]: o tioncl ssh or0tÏs prefix
   0        //ÑhnstinfÔ[3]; the hosuname     ``    $-/$xosvijfo3]: optiooa|†popÙ number
      † Ä   //Tje Ëost strÌnÁ xrefÈx can teMporarMly!nVurride t»m curr%.p†se4tÈnG gor SMTPSecÙre
            //If it's not sre#)died< tha defewlt vaL5e"is used
   † "      //Cpegj t`e hosv jAme$is a valmd naie +r AP addrgwc before tPying to 4se itJ 0†  (0 "   iÊ0(!suatik:˙i{ValilHost(@crtinfo[2M9) {J   `  ( `       $ˆhis->Âd%jug(dtiis->lelwh'invalyd_ËoÛt') > '!ß!n $(oÛdinfo[0]	;
 † "      ¢ #   cÔntinue?
  †     †   }
  $!  0   ` qzefÈ| = ';
     (      $secure!=  this->SLTPQesure9
   !! (    !$u|S = (p`thb::eFCR[PTION_STARTTL === ddh(3->SM4–SecurE);
   f!      if (sl'bΩ== $hostmnf/[1] l|(('' -== $hosÙiofo[1] &fp≥Patyb:ECRYXTKONﬂSLTPS†=== $tHis->SMTPSegure)) z
     0       0$ $q{mfix ? 'wsd:/ogyä!    #        0 $tLs = dqlse; //CiN't have(QS\ an` DLS at"4he same tIme
($ "  ``!"    ` dsecw2e = st`tic::ENCRYPTAON_sLTPS9
     (  †   } elcÂkf ('tlS' ;5= dhÔsvinf/S1]9 {
  h  $      ! " $tl7 = true3
  0!d     1    //LS dÔesn't uSe ° prefix
      ∞   $"  `$sggura = stctic:>ENKRYpTION_[TCRTTL”;
        `  †}
` $`$!     †--Do we nged the OpeŒSS^ extension?      `  1 $$SslexT(= dedaned(']PENSsL_AHGO_WHA207');
    †  0    I& (st!Tic*:ENCR]PTIONOSPArTL” === $qecuSu l| stiti#*;ENCRYPTiON_SmTPS === d{ecure)8{
  $            "+ChewK f}r !n OpdnWs(aonstant†rqthep tian usiog ex4enÛioÓ_lOaded, which ms Ûomevmmes eisa`led
                yf )!$kslext)"{
   !           †    thrnw`neW Ex„eptÈon(%tÍis->hang('ertensin]missing') . 'op/nssl'l selnz;STpOC“ITIC·L©; !         $ † 0y
    b       }
    0       $hoÛt"9 $hostyNfm[2];
   !     `  $port†= $tjis->Port3
$      $    if (   "   0 †  !"  array_iey_existg(≥,($lostinfo) &&
   !"       (   hs_numÂric($howtIff/S3]) &&
†0        @ † ( $hfsvi.fo[3U > 2 &&
  "           †4hoz|info[;] 4 65536é  (  #(`"   )({
       `"    "  $port = (ilt) $hos4info[3];
`$      0 † }
    d  0  °"ig (thiq,>cmdp->con%2p(§prefix . $xost,†$port, thic->XI-eout, $opt-onc©) {
  †" `     †    tr{ s
     † 0    0     $ hf ($tlis-?HÂlo) {
$  `  #  †   `$  ($ "  †$hglÏk Ω $thk{->Helo;
p     (   !   $†    } dlse {!,  0(         !        hgÏno = $ÙhiS->q%rVmrHo{dnamı();
  "     †   5    0  |
 !     † "(   $     duhi{•>sÌÙp)æiElloh$hellO©;
$†            ®     //AutomaticiÏdy†enable P\S∞eosryrtion$if*
 0          ` `  † ++* i|&q`fot`disabLed
     ` †  0 "!    (`//* wg hivE npun{sl expen{i-n
 ` !     0    $ 0 p†/* ve ire fot alraady using"SsN
    $  !            /.*†the serrer mffers"sDABTTLS
`  "0    †$ @! $   ©f!($thIs,>SMTPAutoTLS &&!§ssMdxt &&(gssN' !== dqecqre &' $thiÛ->sdvP->ÁetQerverExt &STARTVLS')	 {
"              $ $      utlc = tÚwe;ä$` 0 ""0          ( } p"       $# † a "  if ($pls) {  0           " ` $     kf (!$tlis->smvp-ûstazt‘LS())"{
              †    ( 4  (   $meswaÁu 9 $t,is->ge|S-6tErrorMessage('cnnmct^hosdg);$   "    0†   a    †  b  2P vhÚm new exCepÙioF(,Message);
       ((   1     !    }
          ` (    ("†    ./We mUsT r%sene EHLO after TNS negotiqtimn
   $        $0    0     $this->smpp->hedho($hÂl,e);
  !0   ® (  `  $ 0  }O †   †"          † "if (
    c`  (0      @"     ÙthIs≠>SMTPAuth &&`!$thÈs/>{mup->a}theÓtic!dd(
!        (‡0 $  ` ! (       $th)s->Usmrnamu,
 "0 00  Ë    ! 0    2 $  ™ $th¯s-.Pqsswgr$
   "    !† $   !     a "†  0this->Autjuyr%l
 &   "       `$  `  $ " ( °  tËis->oauth
!† †  `"! ("  " *       )
 †   `0†    "    (  © {       `  !   !`+       |hrow†new†Ex'epthon($This)>laNg®'aUth`ntikate')+;
      !`0      ® 0  u

  "      0"         zeturn urue;
" "† 0  !   "   } „atkË (Mxceptkon exc8 {
      0       $ $  "$lastexception!= 4g8`; ®  †       † !      this,>edebu'($exc-6gdtMessaga());
!0 (          !     //wm must »aˆe conjebded,!b5t then fcÈled TLS or"Autl,†so clnse cOnnUkthoo nicdly!0 @  (0       b  ( $t(is->smtp->quit((;ä0   †     $   @0}
$`        "(y
     $ 4y
 "  ($  //if we gev h-ra, all coNnÂsdÈol`IÙtempls ha6e naimed,"S/0#lose coÓnesTioN`harfJ  0 `   thi{>smtp>blkse*);
    (   '/As we've caught ald`Eyceptkon¨ jtsÙ report whaueveZ thm last`one was
    0   if :$djÈy->exgepions!&& nul<`!== $laste|CepTion) i
         (  rhsow dnaÛtexcettion;        }
     †  if(($this≠zeËceptiols) {
         h  '/ no`excÂxtiÔn w!S t`rown."liIimy $this.wmtp)>conneCt()@failed
        †0 ($}Essage 5 $uhis-æg%tSe˛pErrorMmssqgm®'connecÙ_ist');
  0 " ` (   throw .gw Exception(4}essqgm)3
    $ ""}
 0      r·turn false;
 0  
  ( /n
    (( ClÔse Ùie active`SMDP sesÛion0if oÓe exists.ä  0  */    pu‚li„ fÙncdioo sÌtpBlgsu(9
    {+      0 if 8)nÂnl2!==!$4his->smtr)$&' $|his->smtp->conlectef))) {
            0thir%>sm|P->qd©t();  0 $    †  dthis->Smtp->close(); "   †( }
$   }

0  `/
j
 (   +∞Sut!the lajfuage fOr urror Messager'
$ †$ * The defqulÙ la/gua'e is English.
     +
0 !  * hparaM sÙrine $mangcoDe$ ISN 639-1 2-char!cter la˛g5age$code (e.g. French is "fr !
   ! *`        †`   `  `  0     OtioN`Ïly, the languagmÄcode$caÓ be %nhanc·` wiDi a 4-aharacter†` † *``    ! 0`   $0$ ! $      sCript annotation0and/nr a 2mcËaracuer country ann.tation.
   !#* @paraÂ strinÁ $lcng_path Path!toe4he language!file `irecpory, witl†t2ailhng separcpor ,slash)
   , (   †             " †  "  !Do not set txiS fRoÌ uses Èvputa
     

     * @r%turn `ool eÙu"ns†true )f txe(req5ewded languige was do`ded, fanse kthepw9se.
 ®   
/
  "publac fWnctyon!sevLingwa'e(4la/gcOde = 7en', $|ang_p th = '/)
    {
     ( (o+Ba„kw·rds soÌd`pibi~ity$vgp$Ren`ead lijfuage kodms
        $renimed€LanG„odes = [
   †  $† P  'br' => 'pt_br',
   †     $  #cz'`=> 'c{',
 ) "    † 0 'Lk% =. %Fa',
  0         'no' =.$'nb',
 !     !  ` &se' ?>0'cv#,
      †$   !'rs& 9æ 'sr'$
†  `  †     'tÁ' =60%tl',
   ‡   !9$  'am' => /hy&¨
(  $  ! ]{

∞   `  $if:(ar0ai_key_existS(,lQngCo$Â, $renimed_lajgcodes))(k
(    0     !$langco`e†} $pMnqmed_lang#oder[dlangcfde]{  †     }
   !  " o/Eefine full set ofdtranslaVabla stzings hn2Enehish†  (    $PLPMAILEV_LENG = [   †  0     'ae|henvya·td'(=> S]VP Erpo2:(Sould not att(enticate.',
$% B$       'bdcgy_php'$=: 'Yo}r ver{aoÊ od TH(is affectef `y ``bug that ma{ resuhp iL aOrrupted0-essage„.' &
$ `   ($        . To fix )d, switch to sending usiŒg SMTP¨ dyÛa`le the maih'qdd_x_headdr npÙioN iÓ' .
         (    †0#"ynqr p‡p.inÈ,`sitch to IabOS$or(Linex,$or upgradd(YouÚ HP to`version 7.0&17+ or*?3.3+(g.
 !         0'cÔnnecp[host# => 'SMTê Grpkr8 Ckuld`not connect`vo MVP xostnß,
` Ä    (  ( %data]nopﬂacsepte‰' =>0'SMTP Urror: `ata no‘`accetted.',
       !   !'emxty_massage' Ω. 'MasÛage body(eopty/,
$      0    'encoding' => 'Unknowl encnDing: '=
 †    0`    'dxe#q·E' => 'Sou`d nÔt gxecute: '
( $   (!    #extdf#iN_missing' => 'Extension$Ì)ÛsinÁ: /(
        †   'vilE_dCcgss' 6 'Could nod accesS fie: ',
     !     !'film_Open' => 'File MrrOr:!Cn5ld not /pen fine: ',
      `  $  'fskmﬂvaila`' %> '‘he following FrÔm addresq faila@; ',!"  0  †  † 'i<s4Anticte' > 'AOul` nkt ynstantiate`maih function.',
         `  'invami‰[atdrmss' => 'Invalmd adreqs: ',
 (      $ 0 'anvalÈd_heaDg' =: &InvaÏmd headev jame or vcmue'¨$  "        'inv!lid_hosuentÚy'a=> 'Invqlid host%Óvsy∏ ',
(           'aovali$_lowt' =? 'Inrali‰ host: '¨
        )!  'ÌailEr_nop_supported' => ' ÌAilgr(iÛ not supported.'$  0 !   `"d 'pPov)de_eddpass' =6 'You must –rÔvmde aÙ least one recipycnÙ e-ccl,addressn',
     1    ( 'recÈpieNts_Failed£ => 'SMTP Ezrr: The$fÔmLouing recipIeÓts†failedz ',
   `0  0    'sign·nÁ' => 'SigninÁ(≈rrgr: ',
 0       !  'smt0_ckfÂ' ?> 'SMDP bodÂ: ',
  "       ! 'smtp_codÂ_ex' => gAdDIdyon`l(”MTP info: g,
            'smtp^so.nec4_failed'"6 'MTP cÔ.newt0)†6·ined.ß,
     ( !†   7smtp]detail ?> 'N%tail: ',
†     †     'sm4p_erroÚ' }>!/SETP servEr error: 7,
  0† †  `$  'vaRiabhe_seÙ' => 'Cann-t(smt0or zeset ~!riable:0',
$      "›;
        Ad (emPuy,$la.g_pqth9) {
       `  `†//Calculata an absodupe 0a|h so yT can work if CWD$is NT!(eze
         (  $lalg_path = tIsoame)_SDI“__) . @IRUC‘_RY_SEPARA4OR!. 'laoguage' . DIREAOR_SEPABA‘OR3
 †   $  }

h"    $"//almdate $lajgcOd%   (    $foUndle~g0= 4sue;
#  0 (` $laogCodg  = strtolower($jangcmde©;
†  $"  (if ,
   ( "      !preg_match(7/N(?P<l`fg>[a-zL[2˜)(?<sC2ipt>_[a-:]{4})?,?Pgoqntr9>_[a-z]{0|)?$/', $langcnde(0%matchus)
   " "  `  &&†%lang#ode !5=8#gn'
 ( (   †) {
  `(       "$gotn`lang = falsm;
  !   $" (  langcode 5 #dn';ä      $ ˝
 †* !"`'/There is lo`GnglisH tÚanrlatiol f	leJ0      (Èf ('en'†!== $manGcoda) 
   †"    (" 0lCnCcdÂs = [];
!    8 `"!  )N (!gMpty)$matbhes['scriPt'])`&6 1empÙy $mat#`es{/cOuntry']) {J     ` 0        $laogcodes€] = $matChes['lalg'Y .($matches'sarapt']" $matChesY'country'];
           u
 0   2  #   if (°eopp9)&matchıs[/c/}ntry7]() {
0 ("$  $) $  (" ,lanocoddsR] = $Ìatchess'lanc'],.($matches['countr˘']+
 ($    †    }
       "  , if 2!empt{($m·ucxes[/script'›)) {
 `  "  †    0†  $d`nfcodeRKU0<`$matches['lang/]". $matkhes[scrkpt']?ä`      !    ˘
          ( $l!Ógcodus[[†= $latcHes['|ano'];
   ! 0 †    //Try"ind fand a reafabÃe`lAÓguagu fÈlu o/r"the zeq’es<%d"nanguage.
,       d†   fo}ndFile = felse;
            ~oÚeacl ($na.gcodes as  #ode)"s
!"    ( `    †  4lcng_fiLÂ = $lantatx . ßphpmailernlang)' . $c/,e . '.phpg;
$     0 $  0"   if (static8:fidÂJsAccessible($nanÁ_fiLe))0{
( "           `     $foundFile } vrue;
  0           ( !   bÚeÈi;
     `          }
         `0 }

 †  ! $     if ($fo}n‰File =9=p&alce) k
     (`† (    ! $foundl·ng(= balce;
  !       ` }†eÏse ˚
  †          " †,lindc =$fyle($nanß_uilÂ)2* `  !      (   $foreach (fmines us $line) {
 $    "      0    1(//Translation bilg linms l/Ok!li{e tLis:
     `  `         ` /?$PHPMAIlG_LaNG€#authen¸icave'] = 'SMTP-Feiler: AutentifizieruNg fehÏgeschl!gan.';*     !          0(`"./These filGs a2Â pazSed(a{ text"anD not PHP so as |o avomd the posqibility of code injectiol     0 (    !  (   //Sea https:-/blog.stmvenle2itHa.-comØarchyre/mAtah=quOted-rtrino!       0     0 $   $mapc(eS = [];
 $            0    †if (
   ` $                 prgg_latcl"   (   (      $     " 0  (  7/^\$PHPMAILER_LAFG\Z\'a-z\D_]+i\'\UTw*=\s*(Z"\']-(>+)*?\2;/&,
  "  (         (        !   &L)ne,
    0       !$   ` à   !    $lathes $      !  †   0  0    ) f&
† ° "    `     (    † "$/+IwÓgre unknown tpajslatqon0jeys
( †  !  !               azrQy_key^eyists($maTshes[1\, 4P»PÌAINER_LANg)*$ `°%        0 !"`   
      "  `       1      //Oˆerwvite languaÁe-Speckfic strings so†ue'll never xive mirsing tra|sl`tiof†keyq.
(  $#      $ ("    "    $PHPMAALEPGLCŒG[4mCtchEs[1]] ="hstri~')$natches3]{
 2         "        }
        0 († †  }
  ¢    " )  }
$   $∞  }    " $ $this->lefgt`ge = $PIPeAINaS_LANG;

  b  (" retupn0$fnundlA,f)!/'RetuÛns bQlse"if`laNguage`ng4 found   $}

  ` /()  0† * Get Ùhe avray +f strings0for"thg burrelt lioÔ}qogÆ
     *
†    ("@return ars	y
(   */
  " public funcTmn getTranslctaon{()"$ §k
        if†(empty(%Ù`iw-ænanguage)) {
   "  ` !   %|`is-.setLafguage(); // %t the debeult l·nguagu.
0     " }
   "    reÙuÚn $this->lcngwagu;
 !  u

   !?**†    ™ CrÂate recipyent Ëeaders&     *J  ""0* @qiram atrknf $1ype
  `  * @par`m array  %·DdÚ An ar2ay of {eci0menps,
     *    (   $  (      $ (wheze0ea#h reciqienu m3 a 2-element indÂxed ar2ax ˜it` eÏement 0"contaknÌne aÓ `dtvess
  , "* "            $     (!nd dlemgnt(0†co~Tainyfg a n!me, likm:
     *    0     (0  `    ` [Z'jÔe@exampde.cmmß< 'Joe"User'], ['zme@exampld/co/, 'Zoa Tser'_˝
† " *0!   *$@rettro stri~g
 "   j/$   Qublic0funatinn addSAppeld($type, $·Ddr)
  †&{
    ! ` $addre{ces =![];
†  `  0 foreac` ($ader as $adnress) [
 $     h    $alfbewses€]$= $thÈs->ad‰rFoÚmat($addresw);
†    †  }

 *   0  rÂtu2n1§typE .#': ' Æ Èmplode(', ', %ad`bmwsaq) . statis::$LE;
   #˝
*    -**
(    
 FkrMat an address for }su in a Ìmssage h%adÂr.
   $ :   ( * @paraM azrcy addr A 2-dldm%nt indeyed array, elemenÙ 0 containing an†aTdsess, eLmmen| 1 condainmng`q name liie
†    *† (   0 (     0$    [#joe e|amplE.aÁm', cJke User']!   :
  )  * @re\ırn s¸rKng
     */
 )  pubÏy# nunction addrFormat($cddV)
    {
   $   `if $!Isset($addrZ1_) || ($addr[1] === ''©! { //Lo ~!me prkvIded*      (" "( 2mturn $lhis->secureHea‰eb($aDfp[0Y)9‡ ` $  0}
   `    rutwrn §this->elcodeHeaddr(,this->secureIaddr($addr[1]), 'pirpwu'( /         "  ' º' . $this->sesu{eHucder($eddÚ[0]) n 'g;
  ` }

    Ø**
  2  * Word-wrdp lessao.
"! "(* F/v(}Su with -ai|er{`that†do"jot aUtkmatically purform0wrap0ang
   † *$pnd fÔr`1uovÂd-rintable dncoded mesÛqggs.  0  * Original sritten *{ p`ilippe.
  !  *J!(   * @parem!sTri~g $mesSage TJe mes3age to wscp
$    * `par!l inu    $length  The liN%!length to wraP voB  !  * @pa2am@boo|`0$qpmnde Whgpher`to “un in Quotee-PrifÙa‚lE mGde
     *
  $!$* AreturN string $®  */
    5cly√ f5Ógtqoo wrapUex|($message,$$lGÓgth, $qpmode = fÈlsd)
†   {
       †af ($qp_mole) {
    `†     0$sgft_jrdak =†spbindf' =°q'l staTic::$LE);J        } mlse s
          ! $soft_fReak = sua4ic::$LE;
$    "  }
        //If(5tf-8 encodinG i3 ucedl"we wIll neEd tm eake0sure we don'|
 †      /cpnit mulÙibYt% aHa2actdps ˜hen(˜e$sr`
        $as_utd( = {tatig::CHARSET_T&8†== WtrtoloWe‚($tlÈs->Chsret);
  !     $lelen ?@strlen)stItic:z$LE)3
   0 !  $cÚlflen = strlen(spatic::$\E!;
n    ! ` dlEssage 9 svatic:6normalizdBreaks($mes3afe9;
† Å $  $-/Re}oˆe a tramling(mkne†Bveak
 00     kf†(substr($mEssaee,"-&leldn) =<= s|avac"*LE) {Ç      `!    $message = Ûubsur*4messige, 0, )$nele~);
    !  †}
K"†    ! ./Wpmit!md∑sage in|o!lkles
        $}iÓeS = expmode(st`tic::$LE, $messagd)=
    $   ?/Mes[age wil, be rebuilT in hgre    "   $meRwage$= %';
     (  foreach ($dikeq ·s %lIne) {
     !)0    $woVds =†uxplodmh% ', $line); !!0 (   !‡$buf = '/;     (  !   $Dizstwzd = true{
(!     0    fmreach0h$ıordw ms"$worf)({
       ‡    "`  yF )$qp_mo@e $&(sgzÏen($7ord) > $l-ngth©) {
  d         "†     `$srace_‰evt =0$length -!strlEn)$bef) - $crlflen;
 (    `1            kn (!$fhrsvgrd# s
  !  (             †"  )if0($spage_left > 2p) {ä    ‡   ‡              d( † $len < $space_leFt;
$   $       ! $        $    if ($is_utf8) {
               †"       0       $len!= &this-æutf8CjarBoq.paÚy($7Ôb‰,($lun);
  (      !  (    !          } elsgif ('5' ===(su"str($6ord, %l`n - 1, 1)-0{
`       "                       --$hen;
       `  `          (  ( , ˝ elseÈf (ß=/ ->= sÙfstr($7ord-0$len I`2, 1)) {*                  ,"† $1       "$lej†-= rÇ             `  ``      $   -*       "      "   $")   a   $part = qujstr($wor‰. 0å len):
           !(      !Ä      0$˜osd = substv($vkrd, $men)
  *4 4 (  ¢       $    "   ($jıf .=*' ' æ($pabt;
    $ !0    "   `          †$meswqge .= 4buf . {prinTf('=%s', static::$Le)+
†  ( "      0   †Ä0! †  }†glsd"{
 † ` !    †`    %      $!! "$me1sage .=($buÊ`. dsoft_‚paak     ``          "  0   |
!   $      °0"    (     $‚ufd= ''        `   !      (}
 !           $†     whil% (lgord !=4"7')!{
†    $     †  0         if  $length 4= 0) {
 0h $ $         `      0  $ break
         †   "0    0† ! }   (      !      "  (   $len!= $leng|h+
    †    	 `    ` (     iÊ"($is_u|f8) {
         "   0   $  "   !†!$heÓ0="$phis->utf8CHarBÔ5n‰ary(%wÔzd, $lmn)3
2  $ " †  !   !     (("\ e¨se˘b ('='†=== cubspr(word, $Ïel -!1, 1)) {
                 (`  †      =-§lmN9
    (    ( ` a `   !   (} mlseif 	#-# =9= cubstr $wmrd¨ $len - 6. 1+) {
`≤`    !"  !         (    @ $|en -Ω 2
       " 0  †      $   0}
        $               $part = qubstr,%woÚd, 0, (eN-;
     $    !"    (  (    $Wgrd`=0({tring9 substb(&woz‰, $leo):

       0            †   ˘f ($wo{d !-= '') {
              " 0   !      †$meSqaei .- $xcrt > spÚintÊ(ß=-s', sta¥ia:∫$LE):
  "    !  0  0 "(   # ! } ul{e({
          " "    "    (     $bıg$= 4par4;
         " †‡   ""   †  } (     †        `   }
   $          † u else {* `   $  !  4∞    !  $ruf_o < $buf?
     0   †          )f ()%dirStword) {
     !          †(    †$buf .="g ';
`     †  †   0$     ]
  ` 0     4 `       $bug0.= $word?
ö" !           ` ( $ an ('' !== 4buf_o &. sprlel($Bµf) >∞$lefot`) {
        "        à$    $meswage†.= $buf_o . $sofd_break;ã         "$             $Buf = dwOrd;†"  !    (     †    }
     †     †    ˝        "0 ! $  $first7ord = False:  (    $  ! }  "       0 $me3sage .=`$bUd†. stadic:z$LE;
    †$( }

        ret}r& Dmeswage;"   "}

    /
,*   " * ind0the last ciaRactgr!bouo`arx prio2 to &lcxHengpl in e qtf-0
  `0 " quOtet-prÈnTabnÂ eÓcoded(str)ng.
     *$O2iginal wvitten by CoÏÈn ¬bown>
    (+
     *  param stzing ,en#odadText qtf-8 Qp tgxt
     * @iram int   †$ÌaxLength0  Find the la{t char`„Ues bou.dÂby prior tm vhÈs0lmnÁth"    *
     * @return Int
 0 " */0   pu"lic gunction utf8CharBoun‰ar©($%ncnd•dtext, $ma8LinGth)
    y
    $   %fØund”plitQos =!false;
 !  , (`,mokJack = 3
(!      ıhile  !$foundSpliTPos+ 
 "$      †  $lawtChufk = {wbsvr($e~codEdText,@$maxLengTh - &loÔKBag/, $lokKBac+)9*   `   `    $enaodedCh·rPo{ =¢strpow($laÛtChun+, '='9;
 `!     ) `"if()famse )- $encode$CharPos) {
  "        0    //Fuld wtar| of encnded character `yte!withmn0$lokback!blkck.    !    0       //Bheck the eNcoded bype`vamqe t`e 2 clars !dter thu '=')
 `     `        $ze8†= {qbsur($eng/dedText- dmahLengtl -`$ÏookBaGk +  mlcodeT«harPos +†1¨(2):
 $$†   0    $   d`ec = hex`da<$`gx);
          (     if(h$d‰k < 92:) {J             !     (//Shngle byte chiRd„te2Ø
†  0      d     0  //If The eÓcnded char v!s nund a| oq 0,$IT$wiml fit
   † †  "           Æ/othdrwise r%dÙCe maxL%nCth to start of0the"encoded cha:J  $   !             av ($encode`ChArPoc > 4) {
   †       !  "       † $ÈaxLÌngth -= $lÔoiBcck -`d%ÓcodelC(arPs;
"               "   }
 $! †     "   ($$   $foun@SpnitPos = tsee?
`  "    ‡"  8 ( } ulseif"($dec >= 992i {
"         $   !(   0//FiRst byve oF!a Mqlqm by|e cxarab4er
               2    //Reduce eaxMength$to spliu at start Of1cHasact%r
4     †      !(    "$maxLen„th0%= $looÎBa#k - $encodedChar@os;       "(†      "$0 `goundSpli|@ms = true;            " †} %lsÂiv$($eg < q92) {      (!            ?nLiddle `yte of e$multi byte!character, nook furqher back   `(  "  %     !` 0$lonkBakk += #;
"          a    }
          † }!eLce`{
    `         ( //No encoded kharacter foun`
       `  ( !   $foun‰Splmt@oÛ = 4Úue;
$           }
   †    }
       0retUrn$$m`xLmnotË;  ` }
(   /**
     * Apply wo~d wpapping tk 4Ëe mejsagd body.
¢` (!*$Wraus the message&bofy†po tHÂ†~uebep oF$#xcr{ ceÙ in$uh%$Wm2$Wzar psqevdy.
 !   j YÔu shotld onÏy do |nis to†pl·hn-text ¬odies as 3repping JTML0fies may†`rdak themn     * This†is callEd autom`4msal~} bY arÂateBgf}(©. so!you don't need tk banl ht ˘oursell&
``  ≤*Ø`†  purlic fwnction sÂtorfWr°p)(
0   {ä ``%    in†($thic->WopdWrap®<$1) {
  Ä  °     !repurn;
! !     }J
 `$   ` s˜it„x0(&uhIs->Message_type( ˙
     †      sAse #alt':ä !  !"(   )!c·sd 'qlt).lkne':
      †   $ kase&'Alt_Attash#:J!  (  `†    case 'antinli.e_attach':
     "‡"   $0   &this->AltBndy`=∞$thÈs-:wrapText($4has)>AltBody, $thir>WordWrap)
              Ä brdaÎ+ä †  $0$  "" dafat,T2
     *   p   `  $this>Bo`y = $this->wrpText(&dhhs)>BoÊy0$this->UordWve0(ª
           0    bpe!k;       †}Ç0  (}

†   **
    * Assemble ma3wage he`eers.
   $ >
    !( @rUtuÚf†strinf The assembled HeaderÒ
 0`  .? † "`u`lmc0functIon0createIeader()
 !  {
    ( ( $rmsult = '';
 (      $zesumv0.= $this=>®eiderLine('DAte', '' =5= $this->MesS`geDcte ? relf::rfcDque(($∫ $thic->MessageLatm)ª

    §  $+/The DO hdader Iw azeatEd auto}atisally by0mail(), so needc to be ÔMiTtEd heRe
  %  (  ib ('lail' a==$$Ùlis)>Mailer) {
    0$  "   if ,$thiS,>RingÏeTo)`{
!0     !        Noreach ,$txis):to aÛ doaddr9"{) †   "   (        0$thIs->SIngleToQrray[] = $thiq)>!ddzFm~}ct(dvoa`dr);     !          }N"        0! }`elsekf (count 4tlis.>do) > ∞) {
  " "   `  0 (  $result©.µ $tiir->!ddrAp0end('To'- $thiq,>to);
  $      & p •/seiF†(soent $ÙHis≠>cc) 78| 4) {
           &     rÂs}|Ù .=($this->iaadepline('Uo', uÏ`isc,osed=recipielts:?'m´
  `        ,}
``  " !0}    (   %result".= "thiÛ->addrA`pendh/Frwm', [[triM($tXis->Vpom), $this->FvomName]u);

  (     //s%ÓdeAil ald mail*) mxtrac| Cc vrom The0hea$er benoRe sefdinw
"  $    hfb(coult($t(is->gi© æ 0)"{0      "  † $result >= $this-.addrCppend('Bc, ethis>cc)
  `  0  }H
`   $ ( //seodmail ant eail() extrqct ¬cg fpombthe he`les b¡fgre selt)*g
      ` h& (
`  #"   "$  *" p      $   `  'sendmamn' === $v`is)>MaileR \| 'qmail' === $dhis=>a)der†|< 5mail' ===!$this-6Haile2
      0`    +
         !`$& coU&t(4tims-~bgc) > 0
0  $  ( - {
`    *0    $pewu|t .? $this≠>addrAppend('Bcc,$ |`ms-<bcc);
     !$ |
"  "    if (counp(6thirmnReplyDo- >$0) {
       $  $$$requ,| .= this->afdrAppend('Veply-o'$ $this->Reql}To)
 ` †    }
(`†" "  //mail(π suts the 3ubje√t"itsÂlf
!    !  È~ (/mail' !=? §this->Mailev) 
  d d       $Úes]\4 .< $this->headerLine('Subjact'$ $this->enCo‡ehgader$tHis->secureHeaper($th˘s->Rubj%ct(©);
    (   }
      " //Olly allo7 a(gısom mussage ID ig yt cÔnforms Ùo RFC 5322 s%ctko`s.6.0
 †    ( -/xtTPÛ:k/Too,s.igtf.obg/htmlr‚k5322#s%ction-3..4
     !  if((
     "      ''0!]= $|hhs->IessegeIF &ÆJ         ( $psdg]match
†  $ $ $   †0   '/^<,8([c-z\Ñ!#$%&\'*c\=?^_`z|}~,]+(¸.[a-z\`!c$%"\&**\/<?^^a{|}~-]++*)ß . †  $ `  (     †'|("(([\x01-\y08\x0B\x1C\x0E-\x1FÃX7F]|[\x21\x23-^x5B\x5D-\x7E])'"&
    (( !(†  †   '|(\T[p01\q09\x0B\x0C\x0E-^x7GM!!*"))@(([a-z\d°#&%6^'*(\/9?^_`{|}~-Mª'0.
                #(\/[a-z\da'$5&\7*´\>Ω?^^`{|m~-]+)*)|(\{((X801m\x28\x∞B|x0C\p G-\x1G\xF]' .
  (       " "   &|[\x21-\X5A|x=E-\x7E])l(‹\Kx01-\h0;\x0B^x0cx$E-‹x7F]))*\Y)))>$/DÈ'$
8 0            !$Ùhis->Mesq·g%Iƒä        2  !!
† 0``0  ) z
 0  "       %thms->lisvMess!geIE"= this->MeÛwagaID;
 $`(   $} elÛe0{
            $This->lastMassao%ID = wprintd('<•@c>', $phis->uNiyue)t, 4this->serverHoqtncme());
 (      }
      ( $rgsult .= $Ùi)s->heqlarLËne)'Mesqage?ID'< $thms)?lastÕessagmID)ª$0    !`if (null -=} `tX)s,>P~iority)%{
          " $ÚEsudt .=$$this->hÂ`dfRLiÍe('X=Prkori|ym $thi3≠.PrÈoripy	9
        m
     a $i$d('' ==5 $thÎs-/XMAiddr) {
 !   ,     +/Empty sTring &op dÂfqqlt XmMa),er†xdadurJ       &  0 $result*.= $this->h5adurLhfe(   $          " 'X-m·kLer',
!   (         ! 'PAPM`iler ' . se|b::VERSIOn . '((https;//Ci4‡eb.com/PHPMaiour/PHPMei`d˙('
            ©9
       "] elseif((is_string($4HiS,>MIiler)(&& trim(4thkr->XMiÈler) )?="g') s*     "   $  //RoÌe string
    2$      §r%sult .= §|his>xeaderLhnE)'XmLailer', trim(§this->XMaiËe)+;
    (   y //Ot(er valtes$result in"no XMailÂrheadex

 00   § )f ('• !=9 $tiiÛ->CjfirmRe·dingTo) ?
" ( "      ($secult .< $tHac->»ea erLi^a('D)wpnsit)on-NgTificata~-To', < . $tHis->AonfkrmReadin'To`. 'æ&);
  0$† " }

 $ "  $0+?Add(custom hÂaears
    `† $normach ($This->CustomHea‰er a[ $le·de2)({
$          $reSuÌt .}!$thasç>bÂadeRLÈne(
‡  `           $tvim®$hma`gr[0Y),
 #      †    " !$this->encOde»eider(trxm($`dader_1]))
!    `      );
 `!     ]
 ! !    if`,&this-<sign_keyfilu) {
   $  !   †`$recult .= 4u,is/>headerLind('mHME-Vmrsion'l /1.');ã ` "        $resqlt†.= $|his-ÆgEtMailMIME(){†   4   }
     h setur. $rdqult:
†"" }

( †-*(
     * Get th% mess„ge MMME vype (eaders.*  `  **($   ( @rgturf strin'
$    +-   "`u*lic!funwtion oeıMaÈlMAM*)
"(  [Ä †  0  $p!cult = '';
    "   $ismultipQrt = t`ıe; " !    swi|ch 8$\hÈs->meÛsage_tyPeI {
 ( (  †    cas≈ 'i~li|e+:†    ! ( § §   •zesu|t .= $th˘3=>headezLIne('Contenu-T{xe', spatyc0:C_NTENT_TIPE_MULTIPART[PMlATED . '3');
      1`0$     §rÂs5l| n= dthis/>tÂxtLife(' cnınd`ry="' .†$tH(s)>boujd·ryY1]$> '"'(ª
    $     (   $ brea{;†( !$    ` 'cesu!'·|t`ch':
        ! † gqse$&inline_attachg:
  `  4  `   caqe 'alt_at4cch':
 !          ccSe 'alt_ioline_atuach':
         (   †  $Úesult .= $tHis->hÂaderLÈne)'Co.tg.Ù-Vyxe'l Stitkg::CGNPENT_TYE[MLTIP@R_M…ZET n #;/	;
    (    †! "1  $per5lt`.<!$thk3-~taxtLhne' boendary-"' . thm[=?‚mund‡ry[1] ™ ß"%);  (       $†a   breÎk9
  (!(†      case 'a|t':
  (  !  "   case galt_knline':*!               $result Æ< §tLiq-(eaderDhne('Content-Vypg'< static::BOTENU[TYPE_MULTIPARTﬂALTERNATI÷E . ';');
  "  !    `     d2%3ult .=Ä&this-ætextLhne(' boundqrY=& . $phi{->bowndar}[1] . '"/);
               break;
     (     `faFault:  0     0   !   //CI4cHes case 'pd`i~':0and case '':
 0    ("!  †    $rec˜lt .9 &this->textLhne('B+ntent-Type: ' . $this-.KoltentUype . '; charsEt=' / $this-<CËar”et);
† ``   ` †  $  !$ismultipapt = balsa; (         0  ( br%ai;
$  (    }ä    $†  //RFC1341`p!vT(5 #ay{ 5bit is awsumed (f not sreci&aed
    "   if )wtatic::ENCODIN_7BIT !== $t`Is->ElgodiNg) {       0   ( //RFC 2044 sectaon >.4 say3 multiacrt M	ME p·r4s0mey onhy use ?bit, 8bit Ôr"binary KTE
    $     0 if *$)3mu|Tip·pT( [
 ∞   0 (  ! !  $if (sTatic::«nCMDIJG_9BHD -= $4hic->EÓckding- {
0   †    (    ( d   $result /- $thi{~hÂ`d5xLine(/ContEnt-Transfer-Enkotkng',`rPatic::ENCO@IOgs<BiT):
   (        †(  m
       !   0   !+/The /ndy rumaining `dtavnavives Ère quodedmprifteb,% and ja3e64, whic` arE"both 7rat compati‚le
     ( ` $  } else {
  0 †`          $result .< |hiw-æhÂad%rLine 'KonpmntT6aÓzfer-En#Ôding',$$vxis≠>EngfDing);
 † $        }
! †  ,0 }

     $  retupz $rerult;`` (}
J! ` n"*
   $(*(Retur.s the whole ]AME mes3c'g.
     * Inclu$e˚ complete headers and bkdy.
† § * mnly valit qos|`prd3end)). 0   *
 (   * Asee THPMai»er::pzeSelt()
     *
   !(*(@return {4sioG
    (*/
$0  pub<Ic funkta/n gltSentMIMEMessage()
    s `0$    returl qtaÙic:23tripTr`kLingVSP($this->LIMEHeaPd!. &vhÈs/>lailHecdez) .
  †        `statibz:$DE .$s4ctaA::$LE . $4hÈs,>MIM}Body;
0!  }

   0+**†  ` * Cpeat‰&c Uniqu%"ID To usÂ fOr†buldirie{/ä!  )"*
`    *0@retUrn Ûdring
     */
 p  protditad fLbtiÔN gener%teId )    {
 (      4len = 3p; ?/32 bxtes =0256 bits*   0    $*yes = g':
  ` †0  yf (funktimÓ[e<istS('rafdom_bytus'))"{
1(!    !   trq†  & †( $    $    %ryter = random_bYtes($Ïen)
p          "} catCh Ë\E8ceptioÊ!$e9 {* "8  ∞( † †" `  //Do Oouhiog
           "|
        u elrein (vunction_existc(ßkpens˚l_rqj$om_pseudo_bytes')+({
  (0     d  /**a@nmin{PecÙyon&CrypvographicaÏ|yS%„ure“andomna3sINspectioÆ */$           ,bytes = opÂnssh_random_pwuudo_byTes($$en){
 "  (   }
    0  (if ($By`es†== '%)${
 $`      ( $//WÂ failed to poduca 1 qroper randgm svring, cÔ!make do.
 "       ` (/Uae a hcsh to!forge0the Dength†to th% Ûame as0t`E vhez methgds
    $   (  $bqteq = Hash(&sha2567, unÈ3id((striNÂ) mt_rann() true), true-;
$ 0     =
      ( ./We don/u(cÒrÂ abgÙT messin' ut!bas%6u fo2ma| Here, juwu sant a randmm stving* $      rEturn str[pe`Ïace(['=', '+', '/'], ''.`base64_eNcode(hash('sha256', $bytus, true)));
    }

    /**
     * Assemble the message body.
     * Returns an empty string on failure.
     *
     * @throws Exception
     *
     * @return string The assembled message body
     */
    public function createBody()
    {
        $body = '';
        //Create unique IDs and preset boundaries
        $this->setBoundaries();

        if ($this->sign_key_file) {
            $body .= $this->getMailMIME() . static::$LE;
        }

        $this->setWordWrap();

        $bodyEncoding = $this->Encoding;
        $bodyCharSet = $this->CharSet;
        //Can we do a 7-bit downgrade?
        if (static::ENCODING_8BIT === $bodyEncoding && !$this->has8bitChars($this->Body)) {
            $bodyEncoding = static::ENCODING_7BIT;
            //All ISO 8859, Windows codepage and UTF-8 charsets are ascii compatible up to 7-bit
            $bodyCharSet = static::CHARSET_ASCII;
        }
        //If lines are too long, and we're not already using an encoding that will shorten them,
        //change to quoted-printable transfer encoding for the body part only
        if (static::ENCODING_BASE64 !== $this->Encoding && static::hasLineLongerThanMax($this->Body)) {
            $bodyEncoding = static::ENCODING_QUOTED_PRINTABLE;
        }

        $altBodyEncoding = $this->Encoding;
        $altBodyCharSet = $this->CharSet;
        //Can we do a 7-bit downgrade?
        if (static::ENCODING_8BIT === $altBodyEncoding && !$this->has8bitChars($this->AltBody)) {
            $altBodyEncoding = static::ENCODING_7BIT;
            //All ISO 8859, Windows codepage and UTF-8 charsets are ascii compatible up to 7-bit
            $altBodyCharSet = static::CHARSET_ASCII;
        }
        //If lines are too long, and we're not already using an encoding that will shorten them,
        //change to quoted-printable transfer encoding for the alt body part only
        if (static::ENCODING_BASE64 !== $altBodyEncoding && static::hasLineLongerThanMax($this->AltBody)) {
            $altBodyEncoding = static::ENCODING_QUOTED_PRINTABLE;
        }
        //Use this as a preamble in all multipart message types
        $mimepre = '';
        switch ($this->message_type) {
            case 'inline':
                $body .= $mimepre;
                $body .= $this->getBoundary($this->boundary[1], $bodyCharSet, '', $bodyEncoding);
                $body .= $this->encodeString($this->Body, $bodyEncoding);
                $body .= static::$LE;
                $body .= $this->attachAll('inline', $this->boundary[1]);
                break;
            case 'attach':
                $body .= $mimepre;
                $body .= $this->getBoundary($this->boundary[1], $bodyCharSet, '', $bodyEncoding);
                $body .= $this->encodeString($this->Body, $bodyEncoding);
                $body .= static::$LE;
                $body .= $this->attachAll('attachment', $this->boundary[1]);
                break;
            case 'inline_attach':
                $body .= $mimepre;
                $body .= $this->textLine('--' . $this->boundary[1]);
                $body .= $this->headerLine('Content-Type', static::CONTENT_TYPE_MULTIPART_RELATED . ';');
                $body .= $this->textLine(' boundary="' . $this->boundary[2] . '";');
                $body .= $this->textLine(' type="' . static::CONTENT_TYPE_TEXT_HTML . '"');
                $body .= static::$LE;
                $body .= $this->getBoundary($this->boundary[2], $bodyCharSet, '', $bodyEncoding);
                $body .= $this->encodeString($this->Body, $bodyEncoding);
                $body .= static::$LE;
                $body .= $this->attachAll('inline', $this->boundary[2]);
                $body .= static::$LE;
                $body .= $this->attachAll('attachment', $this->boundary[1]);
                break;
            case 'alt':
                $body .= $mimepre;
                $body .= $this->getBoundary(
                    $this->boundary[1],
                    $altBodyCharSet,
                    static::CONTENT_TYPE_PLAINTEXT,
                    $altBodyEncoding
                );
                $body .= $this->encodeString($this->AltBody, $altBodyEncoding);
                $body .= static::$LE;
                $body .= $this->getBoundary(
                    $this->boundary[1],
                    $bodyCharSet,
                    static::CONTENT_TYPE_TEXT_HTML,
                    $bodyEncoding
                );
                $body .= $this->encodeString($this->Body, $bodyEncoding);
                $body .= static::$LE;
                if (!empty($this->Ical)) {
                    $method = static::ICAL_METHOD_REQUEST;
                    foreach (static::$IcalMethods as $imethod) {
                        if (stripos($this->Ical, 'METHOD:' . $imethod) !== false) {
                            $method = $imethod;
                            break;
                        }
                    }
                    $body .= $this->getBoundary(
                        $this->boundary[1],
                        '',
                        static::CONTENT_TYPE_TEXT_CALENDAR . '; method=' . $method,
                        ''
                    );
                    $body .= $this->encodeString($this->Ical, $this->Encoding);
                    $body .= static::$LE;
                }
                $body .= $this->endBoundary($this->boundary[1]);
                break;
            case 'alt_inline':
                $body .= $mimepre;
                $body .= $this->getBoundary(
                    $this->boundary[1],
                    $altBodyCharSet,
                    static::CONTENT_TYPE_PLAINTEXT,
                    $altBodyEncoding
                );
                $body .= $this->encodeString($this->AltBody, $altBodyEncoding);
                $body .= static::$LE;
                $body .= $this->textLine('--' . $this->boundary[1]);
                $body .= $this->headerLine('Content-Type', static::CONTENT_TYPE_MULTIPART_RELATED . ';');
                $body .= $this->textLine(' boundary="' . $this->boundary[2] . '";');
                $body .= $this->textLine(' type="' . static::CONTENT_TYPE_TEXT_HTML . '"');
                $body .= static::$LE;
                $body .= $this->getBoundary(
                    $this->boundary[2],
                    $bodyCharSet,
                    static::CONTENT_TYPE_TEXT_HTML,
                    $bodyEncoding
                );
                $body .= $this->encodeString($this->Body, $bodyEncoding);
                $body .= static::$LE;
                $body .= $this->attachAll('inline', $this->boundary[2]);
                $body .= static::$LE;
                $body .= $this->endBoundary($this->boundary[1]);
                break;
            case 'alt_attach':
                $body .= $mimepre;
                $body .= $this->textLine('--' . $this->boundary[1]);
                $body .= $this->headerLine('Content-Type', static::CONTENT_TYPE_MULTIPART_ALTERNATIVE . ';');
                $body .= $this->textLine(' boundary="' . $this->boundary[2] . '"');
                $body .= static::$LE;
                $body .= $this->getBoundary(
                    $this->boundary[2],
                    $altBodyCharSet,
                    static::CONTENT_TYPE_PLAINTEXT,
                    $altBodyEncoding
                );
                $body .= $this->encodeString($this->AltBody, $altBodyEncoding);
                $body .= static::$LE;
                $body .= $this->getBoundary(
                    $this->boundary[2],
                    $bodyCharSet,
                    static::CONTENT_TYPE_TEXT_HTML,
                    $bodyEncoding
                );
                $body .= $this->encodeString($this->Body, $bodyEncoding);
                $body .= static::$LE;
                if (!empty($this->Ical)) {
                    $method = static::ICAL_METHOD_REQUEST;
                    foreach (static::$IcalMethods as $imethod) {
                        if (stripos($this->Ical, 'METHOD:' . $imethod) !== false) {
                            $method = $imethod;
                            break;
                        }
                    }
                    $body .= $this->getBoundary(
                        $this->boundary[2],
                        '',
                        static::CONTENT_TYPE_TEXT_CALENDAR . '; method=' . $method,
                        ''
                    );
                    $body .= $this->encodeString($this->Ical, $this->Encoding);
                }
                $body .= $this->endBoundary($this->boundary[2]);
                $body .= static::$LE;
                $body .= $this->attachAll('attachment', $this->boundary[1]);
                break;
            case 'alt_inline_attach':
                $body .= $mimepre;
                $body .= $this->textLine('--' . $this->boundary[1]);
                $body .= $this->headerLine('Content-Type', static::CONTENT_TYPE_MULTIPART_ALTERNATIVE . ';');
                $body .= $this->textLine(' boundary="' . $this->boundary[2] . '"');
                $body .= static::$LE;
                $body .= $this->getBoundary(
                    $this->boundary[2],
                    $altBodyCharSet,
                    static::CONTENT_TYPE_PLAINTEXT,
                    $altBodyEncoding
                );
                $body .= $this->encodeString($this->AltBody, $altBodyEncoding);
                $body .= static::$LE;
                $body .= $this->textLine('--' . $this->boundary[2]);
                $body .= $this->headerLine('Content-Type', static::CONTENT_TYPE_MULTIPART_RELATED . ';');
                $body .= $this->textLine(' boundary="' . $this->boundary[3] . '";');
                $body .= $this->textLine(' type="' . static::CONTENT_TYPE_TEXT_HTML . '"');
                $body .= static::$LE;
                $body .= $this->getBoundary(
                    $this->boundary[3],
                    $bodyCharSet,
                    static::CONTENT_TYPE_TEXT_HTML,
                    $bodyEncoding
                );
                $body .= $this->encodeString($this->Body, $bodyEncoding);
                $body .= static::$LE;
                $body .= $this->attachAll('inline', $this->boundary[3]);
                $body .= static::$LE;
                $body .= $this->endBoundary($this->boundary[2]);
                $body .= static::$LE;
                $body .= $this->attachAll('attachment', $this->boundary[1]);
                break;
            default:
                //Catch case 'plain' and case '', applies to simple `text/plain` and `text/html` body content types
                //Reset the `Encoding` property in case we changed it for line length reasons
                $this->Encoding = $bodyEncoding;
                $body .= $this->encodeString($this->Body, $this->Encoding);
                break;
        }

        if ($this->isError()) {
            $body = '';
            if ($this->exceptions) {
                throw new Exception($this->lang('empty_message'), self::STOP_CRITICAL);
            }
        } elseif ($this->sign_key_file) {
            try {
                if (!defined('PKCS7_TEXT')) {
                    throw new Exception($this->lang('extension_missing') . 'openssl');
                }

                $file = tempnam(sys_get_temp_dir(), 'srcsign');
                $signed = tempnam(sys_get_temp_dir(), 'mailsign');
                file_put_contents($file, $body);

                //Workaround for PHP bug https://bugs.php.net/bug.php?id=69197
                if (empty($this->sign_extracerts_file)) {
                    $sign = @openssl_pkcs7_sign(
                        $file,
                        $signed,
                        'file://' . realpath($this->sign_cert_file),
                        ['file://' . realpath($this->sign_key_file), $this->sign_key_pass],
                        []
                    );
                } else {
                    $sign = @openssl_pkcs7_sign(
                        $file,
                        $signed,
                        'file://' . realpath($this->sign_cert_file),
                        ['file://' . realpath($this->sign_key_file), $this->sign_key_pass],
                        [],
                        PKCS7_DETACHED,
                        $this->sign_extracerts_file
                    );
                }

                @unlink($file);
                if ($sign) {
                    $body = file_get_contents($signed);
                    @unlink($signed);
                    //The message returned by openssl contains both headers and body, so need to split them up
                    $parts = explode("\n\n", $body, 2);
                    $this->MIMEHeader .= $parts[0] . static::$LE . static::$LE;
                    $body = $parts[1];
                } else {
                    @unlink($signed);
                    throw new Exception($this->lang('signing') . openssl_error_string());
                }
            } catch (Exception $exc) {
                $body = '';
                if ($this->exceptions) {
                    throw $exc;
                }
            }
        }

        return $body;
    }

    /**
     * Get the boundaries that this message will use
     * @return array
     */
    public function getBoundaries()
    {
        if (empty($this->boundary)) {
            $this->setBoundaries();
        }
        return $this->boundary;
    }

    /**
     * Return the start of a message boundary.
     *
     * @param string $boundary
     * @param string $charSet
     * @param string $contentType
     * @param string $encoding
     *
     * @return string
     */
    protected function getBoundary($boundary, $charSet, $contentType, $encoding)
    {
        $result = '';
        if ('' === $charSet) {
            $charSet = $this->CharSet;
        }
        if ('' === $contentType) {
            $contentType = $this->ContentType;
        }
        if ('' === $encoding) {
            $encoding = $this->Encoding;
        }
        $result .= $this->textLine('--' . $boundary);
        $result .= sprintf('Content-Type: %s; charset=%s', $contentType, $charSet);
        $result .= static::$LE;
        //RFC1341 part 5 says 7bit is assumed if not specified
        if (static::ENCODING_7BIT !== $encoding) {
            $result .= $this->headerLine('Content-Transfer-Encoding', $encoding);
        }
        $result .= static::$LE;

        return $result;
    }

    /**
     * Return the end of a message boundary.
     *
     * @param string $boundary
     *
     * @return string
     */
    protected function endBoundary($boundary)
    {
        return static::$LE . '--' . $boundary . '--' . static::$LE;
    }

    /**
     * Set the message type.
     * PHPMailer only supports some preset message types, not arbitrary MIME structures.
     */
    protected function setMessageType()
    {
        $type = [];
        if ($this->alternativeExists()) {
            $type[] = 'alt';
        }
        if ($this->inlineImageExists()) {
            $type[] = 'inline';
        }
        if ($this->attachmentExists()) {
            $type[] = 'attach';
        }
        $this->message_type = implode('_', $type);
        if ('' === $this->message_type) {
            //The 'plain' message_type refers to the message having a single body element, not that it is plain-text
            $this->message_type = 'plain';
        }
    }

    /**
     * Format a header line.
     *
     * @param string     $name
     * @param string|int $value
     *
     * @return string
     */
    public function headerLine($name, $value)
    {
        return $name . ': ' . $value . static::$LE;
    }

    /**
     * Return a formatted mail line.
     *
     * @param string $value
     *
     * @return string
     */
    public function textLine($value)
    {
        return $value . static::$LE;
    }

    /**
     * Add an attachment from a path on the filesystem.
     * Never use a user-supplied path to a file!
     * Returns false if the file could not be found or read.
     * Explicitly *does not* support passing URLs; PHPMailer is not an HTTP client.
     * If you need to do that, fetch the resource yourself and pass it in via a local file or string.
     *
     * @param string $path        Path to the attachment
     * @param string $name        Overrides the attachment name
     * @param string $encoding    File encoding (see $Encoding)
     * @param string $type        MIME type, e.g. `image/jpeg`; determined automatically from $path if not specified
     * @param string $disposition Disposition to use
     *
     * @throws Exception
     *
     * @return bool
     */
    public function addAttachment(
        $path,
        $name = '',
        $encoding = self::ENCODING_BASE64,
        $type = '',
        $disposition = 'attachment'
    ) {
        try {
            if (!static::fileIsAccessible($path)) {
                throw new Exception($this->lang('file_access') . $path, self::STOP_CONTINUE);
            }

            //If a MIME type is not specified, try to work it out from the file name
            if ('' === $type) {
                $type = static::filenameToType($path);
            }

            $filename = (string) static::mb_pathinfo($path, PATHINFO_BASENAME);
            if ('' === $name) {
                $name = $filename;
            }
            if (!$this->validateEncoding($encoding)) {
                throw new Exception($this->lang('encoding') . $encoding);
            }

            $this->attachment[] = [
                0 => $path,
                1 => $filename,
                2 => $name,
                3 => $encoding,
                4 => $type,
                5 => false, //isStringAttachment
                6 => $disposition,
                7 => $name,
            ];
        } catch (Exception $exc) {
            $this->setError($exc->getMessage());
            $this->edebug($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return false;
        }

        return true;
    }

    /**
     * Return the array of attachments.
     *
     * @return array
     */
    public function getAttachments()
    {
        return $this->attachment;
    }

    /**
     * Attach all file, string, and binary attachments to the message.
     * Returns an empty string on failure.
     *
     * @param string $disposition_type
     * @param string $boundary
     *
     * @throws Exception
     *
     * @return string
     */
    protected function attachAll($disposition_type, $boundary)
    {
        //Return text of body
        $mime = [];
        $cidUniq = [];
        $incl = [];

        //Add all attachments
        foreach ($this->attachment as $attachment) {
            //Check if it is a valid disposition_filter
            if ($attachment[6] === $disposition_type) {
                //Check for string attachment
                $string = '';
                $path = '';
                $bString = $attachment[5];
                if ($bString) {
                    $string = $attachment[0];
                } else {
                    $path = $attachment[0];
                }

                $inclhash = hash('sha256', serialize($attachment));
                if (in_array($inclhash, $incl, true)) {
                    continue;
                }
                $incl[] = $inclhash;
                $name = $attachment[2];
                $encoding = $attachment[3];
                $type = $attachment[4];
                $disposition = $attachment[6];
                $cid = $attachment[7];
                if ('inline' === $disposition && array_key_exists($cid, $cidUniq)) {
                    continue;
                }
                $cidUniq[$cid] = true;

                $mime[] = sprintf('--%s%s', $boundary, static::$LE);
                //Only include a filename property if we have one
                if (!empty($name)) {
                    $mime[] = sprintf(
                        'Content-Type: %s; name=%s%s',
                        $type,
                        static::quotedString($this->encodeHeader($this->secureHeader($name))),
                        static::$LE
                    );
                } else {
                    $mime[] = sprintf(
                        'Content-Type: %s%s',
                        $type,
                        static::$LE
                    );
                }
                //RFC1341 part 5 says 7bit is assumed if not specified
                if (static::ENCODING_7BIT !== $encoding) {
                    $mime[] = sprintf('Content-Transfer-Encoding: %s%s', $encoding, static::$LE);
                }

                //Only set Content-IDs on inline attachments
                if ((string) $cid !== '' && $disposition === 'inline') {
                    $mime[] = 'Content-ID: <' . $this->encodeHeader($this->secureHeader($cid)) . '>' . static::$LE;
                }

                //Allow for bypassing the Content-Disposition header
                if (!empty($disposition)) {
                    $encoded_name = $this->encodeHeader($this->secureHeader($name));
                    if (!empty($encoded_name)) {
                        $mime[] = sprintf(
                            'Content-Disposition: %s; filename=%s%s',
                            $disposition,
                            static::quotedString($encoded_name),
                            static::$LE . static::$LE
                        );
                    } else {
                        $mime[] = sprintf(
                            'Content-Disposition: %s%s',
                            $disposition,
                            static::$LE . static::$LE
                        );
                    }
                } else {
                    $mime[] = static::$LE;
                }

                //Encode as string attachment
                if ($bString) {
                    $mime[] = $this->encodeString($string, $encoding);
                } else {
                    $mime[] = $this->encodeFile($path, $encoding);
                }
                if ($this->isError()) {
                    return '';
                }
                $mime[] = static::$LE;
            }
        }

        $mime[] = sprintf('--%s--%s', $boundary, static::$LE);

        return implode('', $mime);
    }

    /**
     * Encode a file attachment in requested format.
     * Returns an empty string on failure.
     *
     * @param string $path     The full path to the file
     * @param string $encoding The encoding to use; one of 'base64', '7bit', '8bit', 'binary', 'quoted-printable'
     *
     * @return string
     */
    protected function encodeFile($path, $encoding = self::ENCODING_BASE64)
    {
        try {
            if (!static::fileIsAccessible($path)) {
                throw new Exception($this->lang('file_open') . $path, self::STOP_CONTINUE);
            }
            $file_buffer = file_get_contents($path);
            if (false === $file_buffer) {
                throw new Exception($this->lang('file_open') . $path, self::STOP_CONTINUE);
            }
            $file_buffer = $this->encodeString($file_buffer, $encoding);

            return $file_buffer;
        } catch (Exception $exc) {
            $this->setError($exc->getMessage());
            $this->edebug($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return '';
        }
    }

    /**
     * Encode a string in requested format.
     * Returns an empty string on failure.
     *
     * @param string $str      The text to encode
     * @param string $encoding The encoding to use; one of 'base64', '7bit', '8bit', 'binary', 'quoted-printable'
     *
     * @throws Exception
     *
     * @return string
     */
    public function encodeString($str, $encoding = self::ENCODING_BASE64)
    {
        $encoded = '';
        switch (strtolower($encoding)) {
            case static::ENCODING_BASE64:
                $encoded = chunk_split(
                    base64_encode($str),
                    static::STD_LINE_LENGTH,
                    static::$LE
                );
                break;
            case static::ENCODING_7BIT:
            case static::ENCODING_8BIT:
                $encoded = static::normalizeBreaks($str);
                //Make sure it ends with a line break
                if (substr($encoded, -(strlen(static::$LE))) !== static::$LE) {
                    $encoded .= static::$LE;
                }
                break;
            case static::ENCODING_BINARY:
                $encoded = $str;
                break;
            case static::ENCODING_QUOTED_PRINTABLE:
                $encoded = $this->encodeQP($str);
                break;
            default:
                $this->setError($this->lang('encoding') . $encoding);
                if ($this->exceptions) {
                    throw new Exception($this->lang('encoding') . $encoding);
                }
                break;
        }

        return $encoded;
    }

    /**
     * Encode a header value (not including its label) optimally.
     * Picks shortest of Q, B, or none. Result includes folding if needed.
     * See RFC822 definitions for phrase, comment and text positions.
     *
     * @param string $str      The header value to encode
     * @param string $position What context the string will be used in
     *
     * @return string
     */
    public function encodeHeader($str, $position = 'text')
    {
        $matchcount = 0;
        switch (strtolower($position)) {
            case 'phrase':
                if (!preg_match('/[\200-\377]/', $str)) {
                    //Can't use addslashes as we don't know the value of magic_quotes_sybase
                    $encoded = addcslashes($str, "\0..\37\177\\\"");
                    if (($str === $encoded) && !preg_match('/[^A-Za-z0-9!#$%&\'*+\/=?^_`{|}~ -]/', $str)) {
                        return $encoded;
                    }

                    return "\"$encoded\"";
                }
                $matchcount = preg_match_all('/[^\040\041\043-\133\135-\176]/', $str, $matches);
                break;
            /* @noinspection PhpMissingBreakStatementInspection */
            case 'comment':
                $matchcount = preg_match_all('/[()"]/', $str, $matches);
            //fallthrough
            case 'text':
            default:
                $matchcount += preg_match_all('/[\000-\010\013\014\016-\037\177-\377]/', $str, $matches);
                break;
        }

        if ($this->has8bitChars($str)) {
            $charset = $this->CharSet;
        } else {
            $charset = static::CHARSET_ASCII;
        }

        //Q/B encoding adds 8 chars and the charset ("` =?<charset>?[QB]?<content>?=`").
        $overhead = 8 + strlen($charset);

        if ('mail' === $this->Mailer) {
            $maxlen = static::MAIL_MAX_LINE_LENGTH - $overhead;
        } else {
            $maxlen = static::MAX_LINE_LENGTH - $overhead;
        }

        //Select the encoding that produces the shortest output and/or prevents corruption.
        if ($matchcount > strlen($str) / 3) {
            //More than 1/3 of the content needs encoding, use B-encode.
            $encoding = 'B';
        } elseif ($matchcount > 0) {
            //Less than 1/3 of the content needs encoding, use Q-encode.
            $encoding = 'Q';
        } elseif (strlen($str) > $maxlen) {
            //No encoding needed, but value exceeds max line length, use Q-encode to prevent corruption.
            $encoding = 'Q';
        } else {
            //No reformatting needed
            $encoding = false;
        }

        switch ($encoding) {
            case 'B':
                if ($this->hasMultiBytes($str)) {
                    //Use a custom function which correctly encodes and wraps long
                    //multibyte strings without breaking lines within a character
                    $encoded = $this->base64EncodeWrapMB($str, "\n");
                } else {
                    $encoded = base64_encode($str);
                    $maxlen -= $maxlen % 4;
                    $encoded = trim(chunk_split($encoded, $maxlen, "\n"));
                }
                $encoded = preg_replace('/^(.*)$/m', ' =?' . $charset . "?$encoding?\\1?=", $encoded);
                break;
            case 'Q':
                $encoded = $this->encodeQ($str, $position);
                $encoded = $this->wrapText($encoded, $maxlen, true);
                $encoded = str_replace('=' . static::$LE, "\n", trim($encoded));
                $encoded = preg_replace('/^(.*)$/m', ' =?' . $charset . "?$encoding?\\1?=", $encoded);
                break;
            default:
                return $str;
        }

        return trim(static::normalizeBreaks($encoded));
    }

    /**
     * Check if a string contains multi-byte characters.
     *
     * @param string $str multi-byte text to wrap encode
     *
     * @return bool
     */
    public function hasMultiBytes($str)
    {
        if (function_exists('mb_strlen')) {
            return strlen($str) > mb_strlen($str, $this->CharSet);
        }

        //Assume no multibytes (we can't handle without mbstring functions anyway)
        return false;
    }

    /**
     * Does a string contain any 8-bit chars (in any charset)?
     *
     * @param string $text
     *
     * @return bool
     */
    public function has8bitChars($text)
    {
        return (bool) preg_match('/[\x80-\xFF]/', $text);
    }

    /**
     * Encode and wrap long multibyte strings for mail headers
     * without breaking lines within a character.
     * Adapted from a function by paravoid.
     *
     * @see http://www.php.net/manual/en/function.mb-encode-mimeheader.php#60283
     *
     * @param string $str       multi-byte text to wrap encode
     * @param string $linebreak string to use as linefeed/end-of-line
     *
     * @return string
     */
    public function base64EncodeWrapMB($str, $linebreak = null)
    {
        $start = '=?' . $this->CharSet . '?B?';
        $end = '?=';
        $encoded = '';
        if (null === $linebreak) {
            $linebreak = static::$LE;
        }

        $mb_length = mb_strlen($str, $this->CharSet);
        //Each line must have length <= 75, including $start and $end
        $length = 75 - strlen($start) - strlen($end);
        //Average multi-byte ratio
        $ratio = $mb_length / strlen($str);
        //Base64 has a 4:3 ratio
        $avgLength = floor($length * $ratio * .75);

        $offset = 0;
        for ($i = 0; $i < $mb_length; $i += $offset) {
            $lookBack = 0;
            do {
                $offset = $avgLength - $lookBack;
                $chunk = mb_substr($str, $i, $offset, $this->CharSet);
                $chunk = base64_encode($chunk);
                ++$lookBack;
            } while (strlen($chunk) > $length);
            $encoded .= $chunk . $linebreak;
        }

        //Chomp the last linefeed
        return substr($encoded, 0, -strlen($linebreak));
    }

    /**
     * Encode a string in quoted-printable format.
     * According to RFC2045 section 6.7.
     *
     * @param string $string The text to encode
     *
     * @return string
     */
    public function encodeQP($string)
    {
        return static::normalizeBreaks(quoted_printable_encode($string));
    }

    /**
     * Encode a string using Q encoding.
     *
     * @see http://tools.ietf.org/html/rfc2047#section-4.2
     *
     * @param string $str      the text to encode
     * @param string $position Where the text is going to be used, see the RFC for what that means
     *
     * @return string
     */
    public function encodeQ($str, $position = 'text')
    {
        //There should not be any EOL in the string
        $pattern = '';
        $encoded = str_replace(["\r", "\n"], '', $str);
        switch (strtolower($position)) {
            case 'phrase':
                //RFC 2047 section 5.3
                $pattern = '^A-Za-z0-9!*+\/ -';
                break;
            /*
             * RFC 2047 section 5.2.
             * Build $pattern without including delimiters and []
             */
            /* @noinspection PhpMissingBreakStatementInspection */
            case 'comment':
                $pattern = '\(\)"';
            /* Intentional fall through */
            case 'text':
            default:
                //RFC 2047 section 5.1
                //Replace every high ascii, control, =, ? and _ characters
                $pattern = '\000-\011\013\014\016-\037\075\077\137\177-\377' . $pattern;
                break;
        }
        $matches = [];
        if (preg_match_all("/[{$pattern}]/", $encoded, $matches)) {
            //If the string contains an '=', make sure it's the first thing we replace
            //so as to avoid double-encoding
            $eqkey = array_search('=', $matches[0], true);
            if (false !== $eqkey) {
                unset($matches[0][$eqkey]);
                array_unshift($matches[0], '=');
            }
            foreach (array_unique($matches[0]) as $char) {
                $encoded = str_replace($char, '=' . sprintf('%02X', ord($char)), $encoded);
            }
        }
        //Replace spaces with _ (more readable than =20)
        //RFC 2047 section 4.2(2)
        return str_replace(' ', '_', $encoded);
    }

    /**
     * Add a string or binary attachment (non-filesystem).
     * This method can be used to attach ascii or binary data,
     * such as a BLOB record from a database.
     *
     * @param string $string      String attachment data
     * @param string $filename    Name of the attachment
     * @param string $encoding    File encoding (see $Encoding)
     * @param string $type        File extension (MIME) type
     * @param string $disposition Disposition to use
     *
     * @throws Exception
     *
     * @return bool True on successfully adding an attachment
     */
    public function addStringAttachment(
        $string,
        $filename,
        $encoding = self::ENCODING_BASE64,
        $type = '',
        $disposition = 'attachment'
    ) {
        try {
            //If a MIME type is not specified, try to work it out from the file name
            if ('' === $type) {
                $type = static::filenameToType($filename);
            }

            if (!$this->validateEncoding($encoding)) {
                throw new Exception($this->lang('encoding') . $encoding);
            }

            //Append to $attachment array
            $this->attachment[] = [
                0 => $string,
                1 => $filename,
                2 => static::mb_pathinfo($filename, PATHINFO_BASENAME),
                3 => $encoding,
                4 => $type,
                5 => true, //isStringAttachment
                6 => $disposition,
                7 => 0,
            ];
        } catch (Exception $exc) {
            $this->setError($exc->getMessage());
            $this->edebug($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return false;
        }

        return true;
    }

    /**
     * Add an embedded (inline) attachment from a file.
     * This can include images, sounds, and just about any other document type.
     * These differ from 'regular' attachments in that they are intended to be
     * displayed inline with the message, not just attached for download.
     * This is used in HTML messages that embed the images
     * the HTML refers to using the `$cid` value in `img` tags, for example `<img src="cid:mylogo">`.
     * Never use a user-supplied path to a file!
     *
     * @param string $path        Path to the attachment
     * @param string $cid         Content ID of the attachment; Use this to reference
     *                            the content when using an embedded image in HTML
     * @param string $name        Overrides the attachment filename
     * @param string $encoding    File encoding (see $Encoding) defaults to `base64`
     * @param string $type        File MIME type (by default mapped from the `$path` filename's extension)
     * @param string $disposition Disposition to use: `inline` (default) or `attachment`
     *                            (unlikely you want this ‚Äì {@see `addAttachment()`} instead)
     *
     * @return bool True on successfully adding an attachment
     * @throws Exception
     *
     */
    public function addEmbeddedImage(
        $path,
        $cid,
        $name = '',
        $encoding = self::ENCODING_BASE64,
        $type = '',
        $disposition = 'inline'
    ) {
        try {
            if (!static::fileIsAccessible($path)) {
                throw new Exception($this->lang('file_access') . $path, self::STOP_CONTINUE);
            }

            //If a MIME type is not specified, try to work it out from the file name
            if ('' === $type) {
                $type = static::filenameToType($path);
            }

            if (!$this->validateEncoding($encoding)) {
                throw new Exception($this->lang('encoding') . $encoding);
            }

            $filename = (string) static::mb_pathinfo($path, PATHINFO_BASENAME);
            if ('' === $name) {
                $name = $filename;
            }

            //Append to $attachment array
            $this->attachment[] = [
                0 => $path,
                1 => $filename,
                2 => $name,
                3 => $encoding,
                4 => $type,
                5 => false, //isStringAttachment
                6 => $disposition,
                7 => $cid,
            ];
        } catch (Exception $exc) {
            $this->setError($exc->getMessage());
            $this->edebug($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return false;
        }

        return true;
    }

    /**
     * Add an embedded stringified attachment.
     * This can include images, sounds, and just about any other document type.
     * If your filename doesn't contain an extension, be sure to set the $type to an appropriate MIME type.
     *
     * @param string $string      The attachment binary data
     * @param string $cid         Content ID of the attachment; Use this to reference
     *                            the content when using an embedded image in HTML
     * @param string $name        A filename for the attachment. If this contains an extension,
     *                            PHPMailer will attempt to set a MIME type for the attachment.
     *                            For example 'file.jpg' would get an 'image/jpeg' MIME type.
     * @param string $encoding    File encoding (see $Encoding), defaults to 'base64'
     * @param string $type        MIME type - will be used in preference to any automatically derived type
     * @param string $disposition Disposition to use
     *
     * @throws Exception
     *
     * @return bool True on successfully adding an attachment
     */
    public function addStringEmbeddedImage(
        $string,
        $cid,
        $name = '',
        $encoding = self::ENCODING_BASE64,
        $type = '',
        $disposition = 'inline'
    ) {
        try {
            //If a MIME type is not specified, try to work it out from the name
            if ('' === $type && !empty($name)) {
                $type = static::filenameToType($name);
            }

            if (!$this->validateEncoding($encoding)) {
                throw new Exception($this->lang('encoding') . $encoding);
            }

            //Append to $attachment array
            $this->attachment[] = [
                0 => $string,
                1 => $name,
                2 => $name,
                3 => $encoding,
                4 => $type,
                5 => true, //isStringAttachment
                6 => $disposition,
                7 => $cid,
            ];
        } catch (Exception $exc) {
            $this->setError($exc->getMessage());
            $this->edebug($exc->getMessage());
            if ($this->exceptions) {
                throw $exc;
            }

            return false;
        }

        return true;
    }

    /**
     * Validate encodings.
     *
     * @param string $encoding
     *
     * @return bool
     */
    protected function validateEncoding($encoding)
    {
        return in_array(
            $encoding,
            [
                self::ENCODING_7BIT,
                self::ENCODING_QUOTED_PRINTABLE,
                self::ENCODING_BASE64,
                self::ENCODING_8BIT,
                self::ENCODING_BINARY,
            ],
            true
        );
    }

    /**
     * Check if an embedded attachment is present with this cid.
     *
     * @param string $cid
     *
     * @return bool
     */
    protected function cidExists($cid)
    {
        foreach ($this->attachment as $attachment) {
            if ('inline' === $attachment[6] && $cid === $attachment[7]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if an inline attachment is present.
     *
     * @return bool
     */
    public function inlineImageExists()
    {
        foreach ($this->attachment as $attachment) {
            if ('inline' === $attachment[6]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if an attachment (non-inline) is present.
     *
     * @return bool
     */
    public function attachmentExists()
    {
        foreach ($this->attachment as $attachment) {
            if ('attachment' === $attachment[6]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if this message has an alternative body set.
     *
     * @return bool
     */
    public function alternativeExists()
    {
        return !empty($this->AltBody);
    }

    /**
     * Clear queued addresses of given kind.
     *
     * @param string $kind 'to', 'cc', or 'bcc'
     */
    public function clearQueuedAddresses($kind)
    {
        $this->RecipientsQueue = array_filter(
            $this->RecipientsQueue,
            static function ($params) use ($kind) {
                return $params[0] !== $kind;
            }
        );
    }

    /**
     * Clear all To recipients.
     */
    public function clearAddresses()
    {
        foreach ($this->to as $to) {
            unset($this->all_recipients[strtolower($to[0])]);
        }
        $this->to = [];
        $this->clearQueuedAddresses('to');
    }

    /**
     * Clear all CC recipients.
     */
    public function clearCCs()
    {
        foreach ($this->cc as $cc) {
            unset($this->all_recipients[strtolower($cc[0])]);
        }
        $this->cc = [];
        $this->clearQueuedAddresses('cc');
    }

    /**
     * Clear all BCC recipients.
     */
    public function clearBCCs()
    {
        foreach ($this->bcc as $bcc) {
            unset($this->all_recipients[strtolower($bcc[0])]);
        }
        $this->bcc = [];
        $this->clearQueuedAddresses('bcc');
    }

    /**
     * Clear all ReplyTo recipients.
     */
    public function clearReplyTos()
    {
        $this->ReplyTo = [];
        $this->ReplyToQueue = [];
    }

    /**
     * Clear all recipient types.
     */
    public function clearAllRecipients()
    {
        $this->to = [];
        $this->cc = [];
        $this->bcc = [];
        $this->all_recipients = [];
        $this->RecipientsQueue = [];
    }

    /**
     * Clear all filesystem, string, and binary attachments.
     */
    public function clearAttachments()
    {
        $this->attachment = [];
    }

    /**
     * Clear all custom headers.
     */
    public function clearCustomHeaders()
    {
        $this->CustomHeader = [];
    }

    /**
     * Add an error message to the error container.
     *
     * @param string $msg
     */
    protected function setError($msg)
    {
        ++$this->error_count;
        if ('smtp' === $this->Mailer && null !== $this->smtp) {
            $lasterror = $this->smtp->getError();
            if (!empty($lasterror['error'])) {
                $msg .= $this->lang('smtp_error') . $lasterror['error'];
                if (!empty($lasterror['detail'])) {
                    $msg .= ' ' . $this->lang('smtp_detail') . $lasterror['detail'];
                }
                if (!empty($lasterror['smtp_code'])) {
                    $msg .= ' ' . $this->lang('smtp_code') . $lasterror['smtp_code'];
                }
                if (!empty($lasterror['smtp_code_ex'])) {
                    $msg .= ' ' . $this->lang('smtp_code_ex') . $lasterror['smtp_code_ex'];
                }
            }
        }
        $this->ErrorInfo = $msg;
    }

    /**
     * Return an RFC 822 formatted date.
     *
     * @return string
     */
    public static function rfcDate()
    {
        //Set the time zone to whatever the default is to avoid 500 errors
        //Will default to UTC if it's not set properly in php.ini
        date_default_timezone_set(@date_default_timezone_get());

        return date('D, j M Y H:i:s O');
    }

    /**
     * Get the server hostname.
     * Returns 'localhost.localdomain' if unknown.
     *
     * @return string
     */
    protected function serverHostname()
    {
        $result = '';
        if (!empty($this->Hostname)) {
            $result = $this->Hostname;
        } elseif (isset($_SERVER) && array_key_exists('SERVER_NAME', $_SERVER)) {
            $result = $_SERVER['SERVER_NAME'];
        } elseif (function_exists('gethostname') && gethostname() !== false) {
            $result = gethostname();
        } elseif (php_uname('n') !== false) {
            $result = php_uname('n');
        }
        if (!static::isValidHost($result)) {
            return 'localhost.localdomain';
        }

        return $result;
    }

    /**
     * Validate whether a string contains a valid value to use as a hostname or IP address.
     * IPv6 addresses must include [], e.g. `[::1]`, not just `::1`.
     *
     * @param string $host The host name or IP address to check
     *
     * @return bool
     */
    public static function isValidHost($host)
    {
        //Simple syntax limits
        if (
            empty($host)
            || !is_string($host)
            || strlen($host) > 256
            || !preg_match('/^([a-zA-Z\d.-]*|\[[a-fA-F\d:]+\])$/', $host)
        ) {
            return false;
        }
        //Looks like a bracketed IPv6 address
        if (strlen($host) > 2 && substr($host, 0, 1) === '[' && substr($host, -1, 1) === ']') {
            return filter_var(substr($host, 1, -1), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
        }
        //If removing all the dots results in a numeric string, it must be an IPv4 address.
        //Need to check this first because otherwise things like `999.0.0.0` are considered valid host names
        if (is_numeric(str_replace('.', '', $host))) {
            //Is it a valid IPv4 address?
            return filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
        }
        //Is it a syntactically valid hostname (when embeded in a URL)?
        return filter_var('http://' . $host, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Get an error message in the current language.
     *
     * @param string $key
     *
     * @return string
     */
    protected function lang($key)
    {
        if (count($this->language) < 1) {
            $this->setLanguage(); //Set the default language
        }

        if (array_key_exists($key, $this->language)) {
            if ('smtp_connect_failed' === $key) {
                //Include a link to troubleshooting docs on SMTP connection failure.
                //This is by far the biggest cause of support questions
                //but it's usually not PHPMailer's fault.
                return $this->language[$key] . ' https://github.com/PHPMailer/PHPMailer/wiki/Troubleshooting';
            }

            return $this->language[$key];
        }

        //Return the key as a fallback
        return $key;
    }

    /**
     * Build an error message starting with a generic one and adding details if possible.
     *
     * @param string $base_key
     * @return string
     */
    private function getSmtpErrorMessage($base_key)
    {
        $message = $this->lang($base_key);
        $error = $this->smtp->getError();
        if (!empty($error['error'])) {
            $message .= ' ' . $error['error'];
            if (!empty($error['detail'])) {
                $message .= ' ' . $error['detail'];
            }
        }

        return $message;
    }

    /**
     * Check if an error occurred.
     *
     * @return bool True if an error did occur
     */
    public function isError()
    {
        return $this->error_count > 0;
    }

    /**
     * Add a custom header.
     * $name value can be overloaded to contain
     * both header name and value (name:value).
     *
     * @param string      $name  Custom header name
     * @param string|null $value Header value
     *
     * @return bool True if a header was set successfully
     * @throws Exception
     */
    public function addCustomHeader($name, $value = null)
    {
        if (null === $value && strpos($name, ':') !== false) {
            //Value passed in as name:value
            list($name, $value) = explode(':', $name, 2);
        }
        $name = trim($name);
        $value = (null === $value) ? '' : trim($value);
        //Ensure name is not empty, and that neither name nor value contain line breaks
        if (empty($name) || strpbrk($name . $value, "\r\n") !== false) {
            if ($this->exceptions) {
                throw new Exception($this->lang('invalid_header'));
            }

            return false;
        }
        $this->CustomHeader[] = [$name, $value];

        return true;
    }

    /**
     * Returns all custom headers.
     *
     * @return array
     */
    public function getCustomHeaders()
    {
        return $this->CustomHeader;
    }

    /**
     * Create a message body from an HTML string.
     * Automatically inlines images and creates a plain-text version by converting the HTML,
     * overwriting any existing values in Body and AltBody.
     * Do not source $message content from user input!
     * $basedir is prepended when handling relative URLs, e.g. <img src="/images/a.png"> and must not be empty
     * will look for an image file in $basedir/images/a.png and convert it to inline.
     * If you don't provide a $basedir, relative paths will be left untouched (and thus probably break in email)
     * Converts data-uri images into embedded attachments.
     * If you don't want to apply these transformations to your HTML, just set Body and AltBody directly.
     *
     * @param string        $message  HTML message string
     * @param string        $basedir  Absolute path to a base directory to prepend to relative paths to images
     * @param bool|callable $advanced Whether to use the internal HTML to text converter
     *                                or your own custom converter
     * @return string The transformed message body
     *
     * @throws Exception
     *
     * @see PHPMailer::html2text()
     */
    public function msgHTML($message, $basedir = '', $advanced = false)
    {
        preg_match_all('/(?<!-)(src|background)=["\'](.*)["\']/Ui', $message, $images);
        if (array_key_exists(2, $images)) {
            if (strlen($basedir) > 1 && '/' !== substr($basedir, -1)) {
                //Ensure $basedir has a trailing /
                $basedir .= '/';
            }
            foreach ($images[2] as $imgindex => $url) {
                //Convert data URIs into embedded images
                //e.g. "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                $match = [];
                if (preg_match('#^data:(image/(?:jpe?g|gif|png));?(base64)?,(.+)#', $url, $match)) {
                    if (count($match) === 4 && static::ENCODING_BASE64 === $match[2]) {
                        $data = base64_decode($match[3]);
                    } elseif ('' === $match[2]) {
                        $data = rawurldecode($match[3]);
                    } else {
                        //Not recognised so leave it alone
                        continue;
                    }
                    //Hash the decoded data, not the URL, so that the same data-URI image used in multiple places
                    //will only be embedded once, even if it used a different encoding
                    $cid = substr(hash('sha256', $data), 0, 32) . '@phpmailer.0'; //RFC2392 S 2

                    if (!$this->cidExists($cid)) {
                        $this->addStringEmbeddedImage(
                            $data,
                            $cid,
                            'embed' . $imgindex,
                            static::ENCODING_BASE64,
                            $match[1]
                        );
                    }
                    $message = str_replace(
                        $images[0][$imgindex],
                        $images[1][$imgindex] . '="cid:' . $cid . '"',
                        $message
                    );
                    continue;
                }
                if (
                    //Only process relative URLs if a basedir is provided (i.e. no absolute local paths)
                    !empty($basedir)
                    //Ignore URLs containing parent dir traversal (..)
                    && (strpos($url, '..') === false)
                    //Do not change urls that are already inline images
                    && 0 !== strpos($url, 'cid:')
                    //Do not change absolute URLs, including anonymous protocol
                    && !preg_match('#^[a-z][a-z0-9+.-]*:?//#i', $url)
                ) {
                    $filename = static::mb_pathinfo($url, PATHINFO_BASENAME);
                    $directory = dirname($url);
                    if ('.' === $directory) {
                        $directory = '';
                    }
                    //RFC2392 S 2
                    $cid = substr(hash('sha256', $url), 0, 32) . '@phpmailer.0';
                    if (strlen($basedir) > 1 && '/' !== substr($basedir, -1)) {
                        $basedir .= '/';
                    }
                    if (strlen($directory) > 1 && '/' !== substr($directory, -1)) {
                        $directory .= '/';
                    }
                    if (
                        $this->addEmbeddedImage(
                            $basedir . $directory . $filename,
                            $cid,
                            $filename,
                            static::ENCODING_BASE64,
                            static::_mime_types((string) static::mb_pathinfo($filename, PATHINFO_EXTENSION))
                        )
                    ) {
                        $message = preg_replace(
                            '/' . $images[1][$imgindex] . '=["\']' . preg_quote($url, '/') . '["\']/Ui',
                            $images[1][$imgindex] . '="cid:' . $cid . '"',
                            $message
                        );
                    }
                }
            }
        }
        $this->isHTML();
        //Convert all message body line breaks to LE, makes quoted-printable encoding work much better
        $this->Body = static::normalizeBreaks($message);
        $this->AltBody = static::normalizeBreaks($this->html2text($message, $advanced));
        if (!$this->alternativeExists()) {
            $this->AltBody = 'This is an HTML-only message. To view it, activate HTML in your email application.'
                . static::$LE;
        }

        return $this->Body;
    }

    /**
     * Convert an HTML string into plain text.
     * This is used by msgHTML().
     * Note - older versions of this function used a bundled advanced converter
     * which was removed for license reasons in #232.
     * Example usage:
     *
     * ```php
     * //Use default conversion
     * $plain = $mail->html2text($html);
     * //Use your own custom converter
     * $plain = $mail->html2text($html, function($html) {
     *     $converter = new MyHtml2text($html);
     *     return $converter->get_text();
     * });
     * ```
     *
     * @param string        $html     The HTML text to convert
     * @param bool|callable $advanced Any boolean value to use the internal converter,
     *                                or provide your own callable for custom conversion.
     *                                *Never* pass user-supplied data into this parameter
     *
     * @return string
     */
    public function html2text($html, $advanced = false)
    {
        if (is_callable($advanced)) {
            return call_user_func($advanced, $html);
        }

        return html_entity_decode(
            trim(strip_tags(preg_replace('/<(head|title|style|script)[^>]*>.*?<\/\\1>/si', '', $html))),
            ENT_QUOTES,
            $this->CharSet
        );
    }

    /**
     * Get the MIME type for a file extension.
     *
     * @param string $ext File extension
     *
     * @return string MIME type of file
     */
    public static function _mime_types($ext = '')
    {
        $mimes = [
            'xl' => 'application/excel',
            'js' => 'application/javascript',
            'hqx' => 'application/mac-binhex40',
            'cpt' => 'application/mac-compactpro',
            'bin' => 'application/macbinary',
            'doc' => 'application/msword',
            'word' => 'application/msword',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'sldx' => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
            'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'class' => 'application/octet-stream',
            'dll' => 'application/octet-stream',
            'dms' => 'application/octet-stream',
            'exe' => 'application/octet-stream',
            'lha' => 'application/octet-stream',
            'lzh' => 'application/octet-stream',
            'psd' => 'application/octet-stream',
            'sea' => 'application/octet-stream',
            'so' => 'application/octet-stream',
            'oda' => 'application/oda',
            'pdf' => 'application/pdf',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',
            'smi' => 'application/smil',
            'smil' => 'application/smil',
            'mif' => 'application/vnd.mif',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'wbxml' => 'application/vnd.wap.wbxml',
            'wmlc' => 'application/vnd.wap.wmlc',
            'dcr' => 'application/x-director',
            'dir' => 'application/x-director',
            'dxr' => 'application/x-director',
            'dvi' => 'application/x-dvi',
            'gtar' => 'application/x-gtar',
            'php3' => 'application/x-httpd-php',
            'php4' => 'application/x-httpd-php',
            'php' => 'application/x-httpd-php',
            'phtml' => 'application/x-httpd-php',
            'phps' => 'application/x-httpd-php-source',
            'swf' => 'application/x-shockwave-flash',
            'sit' => 'application/x-stuffit',
            'tar' => 'application/x-tar',
            'tgz' => 'application/x-tar',
            'xht' => 'application/xhtml+xml',
            'xhtml' => 'application/xhtml+xml',
            'zip' => 'application/zip',
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'mp2' => 'audio/mpeg',
            'mp3' => 'audio/mpeg',
            'm4a' => 'audio/mp4',
            'mpga' => 'audio/mpeg',
            'aif' => 'audio/x-aiff',
            'aifc' => 'audio/x-aiff',
            'aiff' => 'audio/x-aiff',
            'ram' => 'audio/x-pn-realaudio',
            'rm' => 'audio/x-pn-realaudio',
            'rpm' => 'audio/x-pn-realaudio-plugin',
            'ra' => 'audio/x-realaudio',
            'wav' => 'audio/x-wav',
            'mka' => 'audio/x-matroska',
            'bmp' => 'image/bmp',
            'gif' => 'image/gif',
            'jpeg' => 'image/jpeg',
            'jpe' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'webp' => 'image/webp',
            'avif' => 'image/avif',
            'heif' => 'image/heif',
            'heifs' => 'image/heif-sequence',
            'heic' => 'image/heic',
            'heics' => 'image/heic-sequence',
            'eml' => 'message/rfc822',
            'css' => 'text/css',
            'html' => 'text/html',
            'htm' => 'text/html',
            'shtml' => 'text/html',
            'log' => 'text/plain',
            'text' => 'text/plain',
            'txt' => 'text/plain',
            'rtx' => 'text/richtext',
            'rtf' => 'text/rtf',
            'vcf' => 'text/vcard',
            'vcard' => 'text/vcard',
            'ics' => 'text/calendar',
            'xml' => 'text/xml',
            'xsl' => 'text/xml',
            'csv' => 'text/csv',
            'wmv' => 'video/x-ms-wmv',
            'mpeg' => 'video/mpeg',
            'mpe' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mp4' => 'video/mp4',
            'm4v' => 'video/mp4',
            'mov' => 'video/quicktime',
            'qt' => 'video/quicktime',
            'rv' => 'video/vnd.rn-realvideo',
            'avi' => 'video/x-msvideo',
            'movie' => 'video/x-sgi-movie',
            'webm' => 'video/webm',
            'mkv' => 'video/x-matroska',
        ];
        $ext = strtolower($ext);
        if (array_key_exists($ext, $mimes)) {
            return $mimes[$ext];
        }

        return 'application/octet-stream';
    }

    /**
     * Map a file name to a MIME type.
     * Defaults to 'application/octet-stream', i.e.. arbitrary binary data.
     *
     * @param string $filename A file name or full path, does not need to exist as a file
     *
     * @return string
     */
    public static function filenameToType($filename)
    {
        //In case the path is a URL, strip any query string before getting extension
        $qpos = strpos($filename, '?');
        if (false !== $qpos) {
            $filename = substr($filename, 0, $qpos);
        }
        $ext = static::mb_pathinfo($filename, PATHINFO_EXTENSION);

        return static::_mime_types($ext);
    }

    /**
     * Multi-byte-safe pathinfo replacement.
     * Drop-in replacement for pathinfo(), but multibyte- and cross-platform-safe.
     *
     * @see http://www.php.net/manual/en/function.pathinfo.php#107461
     *
     * @param string     $path    A filename or path, does not need to exist as a file
     * @param int|string $options Either a PATHINFO_* constant,
     *                            or a string name to return only the specified piece
     *
     * @return string|array
     */
    public static function mb_pathinfo($path, $options = null)
    {
        $ret = ['dirname' => '', 'basename' => '', 'extension' => '', 'filename' => ''];
        $pathinfo = [];
        if (preg_match('#^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^.\\\\/]+?)|))[\\\\/.]*$#m', $path, $pathinfo)) {
            if (array_key_exists(1, $pathinfo)) {
                $ret['dirname'] = $pathinfo[1];
            }
            if (array_key_exists(2, $pathinfo)) {
                $ret['basename'] = $pathinfo[2];
            }
            if (array_key_exists(5, $pathinfo)) {
                $ret['extension'] = $pathinfo[5];
            }
            if (array_key_exists(3, $pathinfo)) {
                $ret['filename'] = $pathinfo[3];
            }
        }
        switch ($options) {
            case PATHINFO_DIRNAME:
            case 'dirname':
                return $ret['dirname'];
            case PATHINFO_BASENAME:
            case 'basename':
                return $ret['basename'];
            case PATHINFO_EXTENSION:
            case 'extension':
                return $ret['extension'];
            case PATHINFO_FILENAME:
            case 'filename':
                return $ret['filename'];
            default:
                return $ret;
        }
    }

    /**
     * Set or reset instance properties.
     * You should avoid this function - it's more verbose, less efficient, more error-prOne aNd 0   * larDer to debug th·N sevtÈng propmrties di˙ectLy.
     * ]safe Ehample:     * ` mail%set9'sMTPSecuve'- wtauic*:≈Œ√RYPTION_SPARVTLS);`
     *   is 4`e {ame `s:
   §0™<`$mail->SÕPPSekure = stepic::ENCRPTION_START\NS;`>`    *
     * @paraÌ(stRhng &ndme †DÍÂ propezt9†name to†sEt
   ` * @qaram!emxed  $value The val}$ 4o seÙ the property to
 !   *  `  
 @returj!bool
 0  !*/
  † publiÁ"func4ion set®$nale< $vclUe = '')
    {
     *  if (propertq_epists(dthis, $neme)) {
  (         $t`ks-,{$nqme} = Dvalwe;

0          peturn tree;
  ∞   0(}
$     $ ,this->SetError($4His->lang®'vabiabMe]sed'0. ,namei;

"  " 0  retern false?!(  
    /**   ( * Qtrix!ne˜lIfer tO preveot header injection.
†    *
    (* @pa6aM strÈnG $str
$    *
     *0 return string
  (( "/
  $ @ubl)g fenction secureHeader( {tr) †  {
        repurn trim(3trﬂreplace(["\r", ¢\n"], '7, $stb))3
0   }

    /**
 †   * Normalixe lhmm breqks in a qtring.
 $ " * Solverts TNIX LG, M`c`CR and Whodows$CSLF Line†breakr ilto a siogle line brei{ fozmat*
† 0  ™ Dafaunts to GRLG *for IeCsaGe"botyes) And preserves consecut)^e breakÛ.`    *
   ! * Bparam 3trhng $texÙ
  "  * @pasam string $bˆeakdypg Wx`| kind of line br``k tO use; defauLTs$to 3t%tia:8$LE
    Æ
   ` * @return s4ringÇ "   */
    public sTatic function normalireBreaks(4tuxt,0$jreaktype = nıll)*  ` {
        if nqll ==9 $bs%aktype) {
 (( `  P    $‚reaktype =(static::&Le;
 `   ! "}
     0  //Nozmaliqe to \n
        $tgxt = str^rerlacm(Kself::CPLF, "\r"]( "\n", $text);" 0     //Now co~Êert Lu0as needed
        if ("\n" a== abreAk|ype) z
 $     (    ,tex = {trpephace("\n, 4braektype, §text);
    ( ! }

   ,    rcdurn $4e8d;
$p  }
    /**
     * Remove drailing whitespa‚Ì from(a string.
h  " *
!    * @pAram stsifG†$uext
"    b
! !  
 @retusn sTring The teXt to remo6≈ v)ipestaco†f‚om
"    */ä    publ˘c static funct`Ôn straPTrailingGSP($text©ä    {    *∞  RetÙrn`rtrim($vext,†" \r\Ó\t");
    }

    /**
    "* StriP traÈling1mine breaks from a strio'.
 †   
     * @param string $tÂxt
    !*
 ""  *  ÚetuVn sprine The text tn rem/ve breaks from
!    */
    public$static fufctin strip‘6aÈlingBreaks($text)
`   k
  "     revurn†rtpim($text- "\r\n");ä  ` }

∞ ( /
*
     ™ Return the curreNu ,mne break frmaf stzong.
  (  *
     * HrutırÓ spRing
     */    publhc static funCtion geuLO()
  ! {
        retuzn Stau˘c:z$LE+
  ` }

    -**
     * Set the line Break form!t wtbing, e.g. "lp\n".
 ((  *
  $  *†@papaÌ string"$le
 (   *-
   `pbo4ected sta|yc fuoctÈon se4LE,$le!
    {
  (   $ stauic∫:$LE`= $le;ä   (|
  `"o**
     * Set t`g publhb ane pvivqve kuy fmles ajd passWmrd for S/MIME signing.
   0 :
$ $  (`@param string $ceÚt_fhdensme
     *(Aparao string &+eyﬂfile.aee
     * @‡a–am stbing $key_pass      "     ¿asswor` forÄprav·re keY
     *$Bpazam strknga$mxt2acertÛ_fylenIme Optioval q`th to chain c%rDiÊibate
  0  */J $  public fu~ction sigjx$cerT_filename, $kgy_filename,‡$ke{_pas3, $e(traberts_Êilename = /7)
    ª
       ($thys=>sygn_cer5]gil‰ = &cer|_v8lelamm;
        §|`is->sign_9ei_vilE = $ke9_fileÓaÌe3
   ¢    $t`ic->sign_key_pass = $ke˘_pasÛ
        §this->{ign_extrace2tsfite = $extrace2ts_dilename;
   `}*    .**
  0  ™ Quoted-Printibla-encode a DIM$hÂidar.
     +
!    " @pavam sttiÓg $vxt
     *
 0   * @retur. qtring
     */Z8 @$public func4ion0DKIM_SP($txt)
    k
        $line =!'';
        $lej = wtRlen)$txt);
        fÔr (&i!=†0ª 4i < $len; ++$y) {
   ( $      $oÚd = ord(%Ùxt[$i]);          $ if (((4x21 >= nrd) &¶ ($or‰ <= 0x3A)) \| ovd === 0x3C(l| ((0x3E†<?(dovd- &2®($rd 8= 0x7E))) {
             !  $line .=0$txt$i];  0 (       | else {
  $   0$ "      $lane .Ω '=g , sprintv('%02X', $oÚd);
    0‡ `    }
        y
ä"    0 "rEvurf $,ind;
    }

    /™.
 `  * Ganeratea DKIM signaruze.
     *     * Bp·ram strmÓg $sionHeader     *
   † * @thsoww ExcÂptioÓ
  ∞  Í     "!@re4urn strijg"The DCIM signature val5%
     */
    p˝bÏic functHgj DKAM_Sign($sÈg^Headar)
  " {
  `)    iF (!defined 'PC[w_TGX\'-) 
$       !$  if ($This->Âxceqtions) {
  "             tËrow new ExcepÙion($tii{/>laÓg('%xvensikn_}issing') é '/p%nssl');
            }
*      "    (ruvqrn '&;
  0     }
        $privKeYStr = 1‰mp|y($this->DKIM_pzavate_string`?
    0       $pËis).EOYM_pRivate_string :
       " h  file_fet_con4entS($this->DKIM_p6i6q4e)?
      $ if ('' #==∞%thiq,>LKIM_qassp@rase) ˚
  " `       $privKey = ovenssl_piey_ge|_private($privK%ySvr,"$This->DKIM_pasÛphra„e);
        } Âlse {
   $† !     $pri~[gy = gpeÓssl_0cay]gft_private($pravÀgyStr);
      ` }N   #    if ,openssl_s·gn(§qagnHEader<$$signiture $priˆKuy,!'sh!r56Widh“SAEncÛyatio.')i {
          Ä if (\PHP_MABNR_ˆERSiON < x) {   `     †   0  pens3l_pkey[greu($p2ivKÂy);
  "         }

   (( `     return barg6<_encodE($smÓ`¸urd):  "     }
 @     †af (\TH–_MaJORO÷ERS…On º 8+ {
           ¥openssl_rkeyOf`ee($pritKey©;" (      }

$ "     return`&';
  †!}
 (  /**
  (  * «enÂr·tE†a DKII canknical`rition hÂqder.
    
 U3er th% 'relazed' algoritam fRo RFC63w6 section 3.42
     * C·nojmaaÏizad!ima‰erS shÔ}ll *elways+ us• cRLE&`R˝gardness oÊ maildr$setting.
 !   *
 (   * @see httpS2/otools.hEtg>OrgØhtml/rfc6#64+sm„pion-3.4.2
`  ( *
     * @par!m s|rinw!&qhgnLeade" Hua$Âb
!    (
     * @retUrn stringJ !`( */
 0  public funCtÈon DKIM_Headez„($sigÓHeadej)
!   y
   #$   //NormalÈZm bReAks vO CPLF"(regarDless o& tje -ailer)
        $sifnHeade20= sTatic∫8norm`li{mBreaksh$signHeafer( se,g:zCVLF);
!† ` 0 0//Unfold header lknds
        //Nkte PCPE \s$is too brcd a definitkon of whitgsxakÂ; RDG532  defInes iv as `K"\t]@J       "/@seu htuxs//tools>ietf.orgohtml/rFc5322#seation-p.2
 `      //Vhqt meanq thic may bbe!k if yoı do qNmethmNg daft like put veztic!l uabÛ in your!hea`Ers.
   †    $signHeader = prgg_Replace('/\r‹n[ \t]+/', / ', $signHeader!;* " 0    //Break0head`Rr ostbi~t} an arrax
        $lknes = explede(qghf::CRLV< $signHaAdeb);
        &oseach ($\ines as %key => $line© {
 $    †  (  /If |he heceer Is mis3ing · :- skir it as it'q invalid
   $        ./This†is likely to »appen†bmccusa thd extdode,) afove wiml alco Ûplit
  "         +/on the tbai|ing LE, ldaving an Âmpti lhne     (      if (strpos($lio', 'z') ==- falÛe) {
   ` $  !   $   convÈnue;
†           }
0(®`      ( lis4($hea$ing, $valum)(= explode(':', $line,†2);       " 0  //Lower-case!Ëe·der nbme
((    (    $hea`kng = St{tmlower($haading)?
(     0  (  o/Collapre†whide sPace Fi4hin the v·lue, also cojveÚt WSP to sp·ba
:     `†0   $velwe = pregWrepnac%('/[ \t_+/'l ' ', $value)9
0          "//RVC6s76 is sÏigËtly uncle!R herm ≠ it!rays"to delete s0ace!at`t e :endj /n e!ch$fa|uÂ
      "  0  o/Bet uhen sc9c 4o d%lete space be∆ore$and`after the(clon.
        "(  //Fat`2esuLt!iw tie ”ime ic triMmyng both enDq of0the value.
       `    //Ry"el)-ina|i/.$ the s`mı epxlies to tha fkeld namg
$    0      $mines[${ay_ =`trim($Heading,$" \t") &`':'". tRim($ralue,§" \|");
   `    }

$!    $ ret}2n 9mplode(self::BRMF,!$mi~es);
 †  }

0   /**
     * Generate a DKiM`canonhcaliz·tion body.
  $  *`UsÂs"Ùhe 'simple' algjriuhm f2om RFC6366"sebpIof 3Æ\'3.
  †  * Canonicqli˙ed bodie{ shotld *a,gaYS™ }sÂ CRLF, refardless of maÌlEr"satting.
     *
     *†@3ae hpTpq:/'tools.Hetf.Ôrg/htmlØzfc6376#saction-3.4.≥
     *
     * @xaRam strkng($"oeY MesÚagm Bgdy     *ä(   "
 @re|urn!{tr{ngJ     */
    p}blÈc funktion DkIL_BodyC($body)
  $†{
  (     if0(eMpÙx($boey)) {
† (  ` "  ` r%turj0relÊ::CRLF;
"       }
 !  (   //N~rmaN)ze ,i.e gndines to"CRLN
      ( $bo‰y(= static::noÚmali:eFreaks($bodyM self::CRLF);

  $  † d/?ReDuce muluil! trcali~o mine!br≈aks to a(wioglÂ(ong " "    petuzÍ sÙaÙkc::stripTraili.gBrÁaks,$body)  sulÊ::CRHF;
    }
    /**
     ™ Crei0e thu DK	M!h%ader and(body iN e new message$header.
 !   +
     ™ @param strinf $(eaders_line He!der li.e{
   ( * @param stsing $subject      Subject
†  , *$Dparem suring §body         Body
 (   *     * @throws Exception
     *
   $ * @veturn0Û4R)ng
  "  */
  ` xublic functiOn†DKyM_Ald($haaders_line, $subject$ $bOdy)
   0{
        $NKKMsigÓatureTxqT = 'rsa-y(a256'; //Signatupa"& hash AlworÈthms
"     ( %KIMbanonicalizatio~"9 'relcxed/sample'? //Caoonicadization$methols Of$hd!d!z $$body
!       $DIIMquerY =0#dÓs/vxt'ª o.UueÚy†oethol
   †( $ $DKAMtime y Ùime();
  `!    -/Alwi˘s shgn t(%su hea`ers wIt®out being ac)ed
    "   //Rec/mmended list drom hptPs://tools.ievg.org/hTml/rfk6376£sÂCtion-5.4.1*        fiutoSigÓJea$eÚs$= [  !`      $ #from'
  !      "` ßtÔ',
        $  'Cc',
  $    !0 $0'eate,
(    $  (   %sucjecd',  ( †      "7rgply-to',
 †  $       'message-id',
    `    †  7kontÂn4-type<
   †        'mÈma-versIng,
         !  gx-mailEr7,  "!  `(];
   ( († if (stripos($headgRs_lifE, 'Subjectg( ==Ω &alsg)${
 †        $ $healars_lmne >= '[ubÎEct: ' . ,stbjec|`. staıic::$LE;
     (  }J"    $$ $hgcderLinus ? mxtlote)rta|ia::$LE, $Ïe`lmss_linm(;
   % 0  $cuÚrent»%idesLab%l(= '';
     (  dcurÚdntHÂader^alue  '';
    !   $parsedHeaders©= S];
        &jeQderLkNeIndex = 09
  "   0 he·deÚLineCnult"Ω couNt($hegddrLines©;
  !     fkÚecc` ($headerLineÛ aa0$headerLin%) {
      b     $-atches =!Y];
"      0    id (preg_mAtah('/^(S÷ \|]*?)(?{:[ |4]()(,*)$/' $hea,epLane,† mqqchGs))"{       `0 `  (  if%$cerrÁntheaderLabel0!=5 '')  "     !   `   $"   -We wePe pre~iourly!in ÒnOtxEr0hl·der+ Tjis0is"the {0qrt of a new jdadur$ sg save`the(prgvious ond
    ! "      †  $   $parsudIEaddzs[] = ['labelß -> $currentHÂcde"Label, 'value/ ?> $curreltHeaderFalue}:
                }
   "p           $currejÏHeadevL`jel = matchesS1];
     `     $    $currdntheaderVal}e ? $maTchds[2]/
   ∞        } elseif pÚeg^match('/^[ \T;(.*)d/',`&xeal%rLije≠ $matchds))`{
†  $        #   //ƒhi3 is a!fo|de‰ conuinu·tion o‚ t®e"cuvrent leader, s/(unfÏd it         `   `    burtentheaderVal˜E .5 ' ' . $matchew[];
 ($ $  `    }
     "    0(++$hEadfrNineIn‰ex;
      $     if ($h%aderLine	ntex(>=`$he·derLIneCount© {
      (         /?This ˜as thm lpst lmna, so fi~hsh obf`vhi3 hÂader°`         († ` $parsedHgateRw[] Ω ['lebgl' = $#urpentheaderLabul$ &value'`=>!$currentheÒderFanµe\;
       !    } †      }
   ` `   „oiedLeadÂrs†= [_        $`eadepÛToSig.Keys ) [];
    !$  $heatersToSign =![];
        fnreach ($p`rsedHeaders as $header) {
   "0   †  !//ys thys hUader ol, that†eesU "u includgd hL vhe0DIMm†sigjat5re?
     † 1  ! af (alWabray*strtolower($jeider_ßlebel']©, $autoS)gn@eaddrs- urue)) {*            (Ä  §headersToSignKeyr[] = 4hecder['labÂlg_;
          0  ! $$heade‚sToSignk]= $header['libel'] . g: ' . $header['vaÏueß];
† "  †  1@     !if* $this->DKHM_copyHe1derFields)!z
   `†  "      `     $copiedJeaders[] } $headeÚ['lab%\'] . 'z' . //Note nk Ûqace aftdr tHis<"as per RFC
 $†   0        $        spr_repdacÌ8't'¨ &=7C', $txÈs->DKI]_Q–($xeader['6a|ue']));
      ! †       }
             `  continue;
  "  0  (   ]
      $    a//As$ÙliÛ aÓ extra cUstoi headur weáv% been asked |o sm'n?
    "      if†(in_iÚray($heatwr['labdl'], %this/>DKIM_extpa@eadÂr{, trıu))`{
     `† !     " /'Dind its velue in1cÒstm jeadErS
"     $$ (`  $! foreacm ($tHhs->CtstomHeidar as≤$customD%adur) y
      0     "    $  if ($gustomHeeder{ ] == $header[',ebal'])${
 "       †           ! $heafersToSignKeysY} = $leqder['label'];
 `0 ®    0†  $†  00    ($xeaders\oShgn[] = %header['nabel&] .†': ' , $header['vafue'];
 !  "       `(  (     ! if ($thks%?DIIM_goryHeade2Fieldr) {
    (    0   ∞        †     $copiedHdaddvÛ[] = $hepder{'l bel'] .!';' .†/ONote no spqce after!thms, Âs per RFCä            † *          (  (!§ str_rerl·km('|%,$'=7C'¨ %thËq->IL_QP($healerS&~alue]));
              $ $   $   m !  "           b       //Skip!ÛtRaaght to the ngxt he`der
      $ ` †       `   (§continue 23
     †$     $"   $ 0}
   †    "   ` †}   $0  "!  `     &$ }
0       $#opÌedHea`ezFÈeldw ? g?
`     `!if )$this/>DKIM_copyId·terBieles &' coun|h$copiedxeadeÚs) : 0) {
$ 2         /Assdm`lÂ a LKIM$'z/ tag0 ( "0   $  $copitdHeaderFÈelds = ' z='{
`  !   `"   dfib3| =†trud;
    ` † Ä  foreaah (aopie‰HeaderS ac ,copiedHe!d‰p) k
   †( `   †  $" iv (!dfmrst) {
   `   `      00    $copieeJgalerFkulds .= sÙatic::$LD . ' |';
" †    $$  `$  †m
    "  "    0   //Dkl` lojg vaÏues †  0 `  `      if *sTrl%n($copiedHeader+ > self::STD_ÃINE[DNGTH - 3)"{à      !     †    †  4copiddHeqderleldr†.=`subtr(
              §   "†  !*chunk_spdht(copiefHeadgr, se|f::QPDﬂLINE_LEFGTJ†- 3¨ sÙatkc::$Le Æ self:∫FWS),"       !       "       0,
          @    )" ! ! 0 %Ûtrle~(stitic:$LE . {elf∫:FWS)
       "       (    );
  `         !   } Elqu*y
  !            !  $`$cpyÁeHealerFIeles .= $copi·dHe#des;
`  " $  † $"  †0}
       (    † †!,first = false;J`         !$}  `      h b$copiedHeiderFiÂlds .= ';`."s`Atic:8$LE;
     °  }
  (  "! $headdrKeys = ' h=' . iep|oda(/:', $hmaddrsoSÈgnKeys)d* ';' n!s4a|ic:∫$LE;
        dheiderValues`= hmplode(static::$\E, <ha·$er3VoSmgn)
      " $body$=%4his->DKIM_BodyK($bo`y);
        /.B!se&4 of!pacKe,!biÓary(€HA-256 heQl of bmdy
 0    1$DKIMbv4 = bascv4_%ncmƒep!co('H*', h`sh('sha356', $body)));
! !!"!( $idEnt = '7;
  !     if†,'&!!==0$thIs->ƒKIM_hdenTity) {
   `       $ideNt 5 ' È' .($uhi3->DIKM_if%ÓtItq!."';'0. sta4ic::,LE;
    `   ˝
       p//Tje DKIMSign`tqre header is incLUeeu i>$the signcture *excepu fgs*(th$ vAlue of the `b` ‘ag
    Ä † /Øwhhah,is apxÂjded AÊter calculating phe skgnature
!    †  >+)tt0s://tool3.imdf.org'htmlØzfbv36#secÙimo-s.5
$   $02 $dkimSig~axeSeHeadeR =('DKIM-Signcture8`v?1;' .   `  "   ` ' d=' . $this,DIIMdomain . ';G >
$ !   $  0  ' s=' Æ $uja3-6DKIM_selector . w;' . static::$LE .
         ! "% `5' n ,LKIMsigÓ!tuÚeTypu j ';' .
            ' yΩ' . $DKIOquerY . /;'†.
        † ! ' t=' .0$DÀIMtimE0.`';'$.
        `  '(c=' , $DKIMcaÓonicalizatkm. . ';' . static::$LE(.
 $          $headurKeys .
    !      $$idenÙ .
 "          $copaedHealerFÈelds(.
        !   g bh=' æ $dIIMb64 . ';' / statÎc:z LE .
$     (4 †  ' `=';
   $   !//CanonÈcalaz% 4ha set`of0heabers
$ †   " $aajoniaalizedHeidm2s =!$tiis=>E[IM_HMadarC(
   `      ! $`eaderV%l5es . s4cTic∫;$NE . $dkimSigOatureHe!der
  ( (   );
      ( $siGn!ttrÂ = §tlis->KIM_Sign 4aafonicqmizudHeiDerq);*    †   $signatwre =†drim(Chu.k_spli4($sionature, selb*:STƒ_DINE_LE]TI ≠ 3, statÈc::$LE . Ûeldj;NUS));       0re0uZn stqtic2:norMalizeBrGaks(dkym-enapureHeeder . dsignatuse(;
    }

 !  /
*
     ™ Detect if a wTrmog con4ails$`†lina dÔnger(than 4ze ma¯im5m mina length    (* amlowed by RFC 082r!sectio.*2.1.1>
 `"  j
†  † *"PPcrpm 3tring $str
  0  j
"    *!@petwrn†boOlJ   ` "/
    pub,kc sdatyc fuvbti/n hasLi~eLmngerThe.Map($sTr)
(   {
 † (  ! revurn (boOl) zreg_matcl('/^ .{' . (se|&::MAXLINE_LENGPH + strlmn(stqticz:&LE))†. ',=-/e'<0${tr)?
    ]

    /**
    (* If a†stzi/g aont!iÓs an{$&stEcicl" characterw, doublemquote the Namm<
    $j and(escape any $oubme 1}otes Wit` a cEcks|ash.
(    *
8 00 * @xaran$stri~g ${tr*     *
  †0( Argtur. sÙrIng
     *
    "*`¿sde SFC822 3>4.1 ( (†*/
" `$public ±tatic†fun„tion }otedStvinÁ($str)
    {
   $   ‡if (prem_match('/ ()<>@,;:"^/L[]/?]/g,0$str)® { `  d ` 0    ./If$|He s|rinG condainw `ny of theÛe chars, it"must `e d_ub-emqunte@
     `  ` † ?oanD any dnubla"quotes0mu3t,Úg Â3gaped wi|h a back{lash
 !          rgturn '"7(. W|r_ReplacU('"&, '\\"', $qtr)0. 6"';
      ($}

        +oRetubn the!string0un4otched, iÙ$dogsn/t jued quoÙios*"   († $2et5rn $stb;
    u
ä    .**
   !(* ¡llnws for rqblib `%id eccass |o 'to'"pro0evty.
  $  * becgre vhe seNd() call, yueued addressEs( i.e. witj IDN+ are not†qet inc|uded.
  !  *
    !* @r%uurn array
     */
    `e‚lic vunction getoAddresses()
  † {
$$   $"`raturn $this->Ùo;
  4 }
   `/**
 `   * @ljows for pubdic be¡e acCess to,'cc' vroperty.     * J%fOre the send(	 calL- queUed adDresses 8ye> wiÙh IDO) `be0not yet k~cluded.
     *
 †  "* Abe4wÚn$aprcy !!  */
    public bunc|ion(getAcA$dressesh)ä  ! {
 `  ( † Return $this->cb;
‡ ! ]

 †  /**
0 `  * AhlmwS gos pubnic read!accesq t!7bcc' proxerÙ9.     *$BeFore(thd qEnf() cadm,(queıed`addresse3 *iÆe. with IDN) abE n/t yet incl5dee,
     *(    *(Breturj arrqy`*  
o
    public fu~ctign gatBccIddrEsses()
$   [
    `   rEturN $tHiw-:bcC;
`   

0   -**
0%" (* llgws†for publi√ reqd0accesc 4o†'RerlyTo' pvoperÙy/
 %   * BefÔre the send() call,`queeed addresses  ).e. whth$YDN) are not yet Ènc|uded.
 `   b
   ! *`@repurn†`rray
    !*/    pubnic function`getRgplqTo@ddresses()
    {
 4"     beTuR.0$thic-æPepl}\o;
"  (}

`   /*:
 †!  * Allows for†p}blic raad(acCÂss to 'allrecitaents' propErt}.
    2*!Before thd†senf®+ Canl< uqeued!ideressew (i.en witx 	DN) qre*not yet incnuded.
     *
∞    
 AretUrn†arrcy!    */
 †  public function gutAllRacipient@ldÚeSsds()
    {
        re4usn $this->all_zecÈ1iÂ.tc;ä  0 }

    /**
    $*§Pmpvoro$a"ccllbagc.ä     *
0    * @xA"am bool ` $isWent
  $  
 P`ara} ir‡ay  $to
     * @param ·rriy  $cc
  †a * @pcrem array  $"ccj   ` * @pabam stpinc($sıcject     *(@par·m 34ryng $‚o`y
     *!Cparii string $fpom
     
$@param array  $extra   $ *'
!   protected func~ion doalÏback(&MsSuntl $to, $cc, $bcC, $su`j%„t, $so$y, $frmm, %extra	 '  {
    4   )f (!gmpty(%dhis->actinn_Áungtion) && iq_callqble8$dhis-<actakn_funotion)) { " !        call_useÚOfun#(§this->actk{n_functhnn, $ÈsSen4, $tol1$#c, ¨bg„, $sebjecT( $body.!$froml $e¯t`a);
†  (    }J    }

  0 /**
    `* Get the$OAuth‘okdnProwhder iosuanke.
     *ä     * @return OAuthTokenPpovkder
    !*/
(   pUbnic`funCtion getOAuth()ä §  [ä        retuzn $thi{->o·uth;
  †%}

  " ?**
  ∞0 
§Set an(OAuthTokenPrgvydÂr instance.
$  ( */
8   rublic function setOAuth(OAuth‘OkenProvader$$oaUuH)
    {
      $this->oauth = $oauth;
    }
}
