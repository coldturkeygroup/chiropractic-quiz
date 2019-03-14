<?php

namespace ColdTurkey\ChiroQuiz;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly.

// Composer autoloader
require_once CHIRO_QUIZ_PLUGIN_PATH . 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FrontDesk
{
    protected $api_url;
    protected $api_key;
    protected $api_version = 2;
    protected $api_base;
    protected $guzzle;

    /**
     * Basic constructor for the FrontDesk class
     */
    public function __construct()
    {
        $this->api_source = get_option('pf_chiro_quiz_crm_source', 'platformcrm');
        $this->api_base = 'https://' . $this->api_source . '.com/api/v' . $this->api_version . '/';
        $this->api_key = get_option('pf_chiro_quiz_frontdesk_key');
        $this->guzzle = new Client();

        // Display admin notices when required
        add_action('admin_notices', [$this, 'adminNotices']);
    }

    /**
     * Set the FrontDesk API Key
     *
     * @param $api_key
     *
     * @return $this
     */
    public function setApiKey($api_key)
    {
        if ($api_key != false && $api_key != null && $api_key != '') {
            $this->api_key = $api_key;
        }

        return $this;
    }

    /**
     * Create a campaign on tryfrontdesk.com
     * using the given data.
     *
     * @param string $title
     * @param string $permalink
     */
    public function createCampaign($title, $permalink)
    {
        try {
            if ($this->api_key != null || $this->api_key != '') {
                $response = $this->guzzle->post($this->api_base . 'campaigns/', [
                    'form_params' => [
                        'key'         => $this->api_key,
                        'title'       => $title,
                        'description' => 'Campaign for Platform Chiro Quiz',
                        'type'        => 'Platform',
                        'total_cost'  => '10000',
                        'source'      => $permalink
                    ]
                ]);

                add_filter('redirect_post_location', [$this, 'add_success_var'], 99);

                return json_decode($response->getBody(), true)['data']['id'];
            }
        } catch (RequestException $e) {
            add_filter('redirect_post_location', [$this, 'add_error_var'], 99);
        }
    }

    /**
     * Update an existing FrontDesk campaign
     * with a new title or permalink.
     *
     * @param $id
     * @param $title
     * @param $permalink
     */
    public function updateCampaign($id, $title, $permalink)
    {
        if ($this->api_key != null || $this->api_key != '') {
            $this->guzzle->patch($this->api_base . 'campaigns/' . $id, [
                'form_params' => [
                    'key'    => $this->api_key,
                    'title'  => $title,
                    'source' => $permalink
                ]
            ]);
        }
    }

    /**
     * Create a prospect on tryfrontdesk.com
     * using the given data.
     *
     * @param array $data
     *
     * @return json|null
     */
    public function createProspect($data)
    {
        try {
            if ($this->api_key != null || $this->api_key != '') {
                $response = $this->guzzle->post($this->api_base . 'subscribers/complete', [
                    'form_params' => [
                        'key'         => $this->api_key,
                        'campaigns'   => $data['campaign_id'],
                        'email'       => $data['email'],
                        'first_name'  => $data['first_name']
                    ]
                ]);

                return json_decode($response->getBody(), true)['data']['id'];
            }

            return null;
        } catch (RequestException $e) {
            return null;
        }
    }

    /**
     * Update an existing prospect on tryfrontdesk.com
     * using the given data.
     *
     * @param int $id
     * @param array $data
     *
     * @return json|null
     */
    public function updateProspect($id, $data)
    {
        try {
            if ($this->api_key != null || $this->api_key != '') {
                $response = $this->guzzle->patch($this->api_base . 'subscribers/' . $id, [
                    'form_params' => [
                        'key'       => $this->api_key,
                        'email'     => $data['email'],
                        'last_name' => $data['last_name'],
                        'address'   => $data['address'],
                        'address_2' => $data['address_2'],
                        'city'      => $data['city'],
                        'state'     => $data['state'],
                        'zip_code'  => $data['zip_code'],
                        'phone'     => $data['phone']
                    ]
                ]);

                return json_decode($response->getBody(), true)['data']['id'];
            }

            return null;
        } catch (RequestException $e) {
            return null;
        }
    }

    /**
     * Create a note for an existing FrontDesk prospect
     *
     * @param $id
     * @param $title
     * @param $content
     *
     * @return null
     */
    public function createNote($id, $title, $content)
    {
        try {
            if ($this->api_key != null || $this->api_key != '') {
                $response = $this->guzzle->post($this->api_base . 'subscribers/notes/', [
                    'form_params' => [
                        'key'           => $this->api_key,
                        'subscriber_id' => $id,
                        'title'         => $title,
                        'content'       => $content
                    ]
                ]);

                return json_decode($response->getBody(), true)['data']['id'];
            }

            return null;
        } catch (RequestException $e) {
            return null;
        }
    }

    /**
     * Pass a success notification while
     * in the admin panel if necessary
     *
     * @param string $location
     *
     * @return mixed
     */
    public function add_success_var($location)
    {
        remove_filter('redirect_post_location', [$this, 'add_success_var'], 99);

        return esc_url_raw(add_query_arg(['pf_chiro_quiz_frontdesk_success' => true], $location));
    }

    /**
     * Pass a error notification while
     * in the admin panel if necessary
     *
     * @param string $location
     *
     * @return mixed
     */
    public function add_error_var($location)
    {
        remove_filter('redirect_post_location', [$this, 'add_error_var'], 99);

        return esc_url_raw(add_query_arg(['pf_chiro_quiz_frontdesk_error' => true], $location));
    }

    /**
     * Define the different administrator notices
     * that may be displayed to the user if necessary.
     *
     * @return string
     */
    public function adminNotices()
    {
        if (isset($_GET['pf_chiro_quiz_frontdesk_error'])) {
            echo '<div class="error">
	      			<p>A Campaign with this URL already exists. No new Platform CRM Campaign has been created.</p>
						</div>';
        }

        if (isset($_GET['pf_chiro_quiz_frontdesk_success'])) {
            echo '<div class="updated">
	      			<p>A Campaign for this Chiro Quiz has been successfully setup on Platform CRM!</p>
						</div>';
        }
    }
}
