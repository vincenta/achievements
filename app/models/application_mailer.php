<?php

/**
 * This file is part of Achievements. Achievements is free software released
 * under the terms of the GNU AGPL Licence. You should have received a copy of
 * the GNU Affero General Public License along with Achievements. If not, see
 * <http://www.gnu.org/licenses/>.
 *
 * DummyMailTransport class, just log the mail (used in development environment)
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class DummyMailTransport implements SIMailTransport {

    public function send(SMail $mail) {
        SLogger::get_instance()->log($mail->__toString());
    }
}


/**
 * ApplicationMailer class, used to compose and send mails
 * 
 * @copyright Copyright (c) 2009 Vincent Alquier
 * @author Vincent Alquier <vincent.alquier@gmail.com> 
 * @license AGPL 3.0
 */
class ApplicationMailer extends SMailer {
    protected $cc;
    protected $bcc;

    /**
     * Constructor 
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        self::set_template_root(STATO_APP_ROOT_PATH.'/app/views/mails');
        if (STATO_ENV == 'development')
            self::set_default_transport(new DummyMailTransport());
    }

    /**
     * Method used to create a mail (called by prepare)
     * @param string $method_name
     * @param array  $args
     * @access public
     * @return void
     */
    public function create($method_name, $args) {
        $mail = parent::create($method_name, $args);

        if (!is_array($this->cc)) $this->cc = array($this->cc);
        foreach ($this->cc as $cc) {
            if (is_array($cc)) $mail->add_cc($cc[0], $cc[1]);
            else $mail->add_cc($cc);
        }

        if (!is_array($this->bcc)) $this->bcc = array($this->bcc);
        foreach ($this->bcc as $bcc) {
            if (is_array($bcc)) $mail->add_bcc($bcc[0], $bcc[1]);
            else $mail->add_bcc($bcc);
        }

        return $mail;
    }

    /**
     * Used to easily initialize the mailer
     * @param string $subject
     * @param string $body
     * @param string $from
     * @param array  $recipients
     * @param array  $cc
     * @param array  $bcc
     * @access public
     * @return void
     */
    protected function default_mail($subject, $body, $from = null, $recipients, $cc = null, $bcc = null) {
        $this->reset();
        $this->subject = $subject;
        $this->body = $body;
        $this->from = (isnull($from) ? DEFAULT_MAIL_FROM : $from);
        $this->recipients = $recipients;
        $this->cc = $cc;
        $this->bcc = $bcc;
    }

    /**
     * The signup notification
     * body is loaded by the create method, from the template
     * @param User $user
     * @access public
     * @return void
     */
    protected function signup_notification($user) {
        $this->subject = '[ACHIEVEMENTS] Your account registration';
        $this->body = array(
            'user'      => $user,
            'login_url' => url_for(array('controller' => 'login'))
        );
        $this->from = DEFAULT_MAIL_FROM;
        $this->recipients = array(
            array( $user->email, $user->login )
        );
    }

    /**
     * The password reminder mail initialisation
     * body is loaded by the create method, from the template
     * @param User $user
     * @access public
     * @return void
     */
    protected function password_reminder($user) {
        $this->subject = '[ACHIEVEMENTS] Password reminder';
        $this->body = array(
            'user'      => $user,
            'login_url' => url_for(array('controller' => 'login'))
        );
        $this->from = DEFAULT_MAIL_FROM;
        $this->recipients = array(
            array( $user->email, $user->login )
        );
    }

}

