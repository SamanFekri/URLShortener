<?php
/**
 * Created by PhpStorm.
 * User: nmc2010
 * Date: 10/10/2016
 * Time: 6:12 PM
 */
if (!class_exists('Designmodo_Social_Count')) {
    class Designmodo_Social_Count
    {

        function __construct()
        {

            add_shortcode('facebook-share', array($this, 'facebook_share'));

            add_shortcode('facebook-page-like', array($this, 'facebook_page_like'));

            add_shortcode('pinterest-count', array($this, 'pinterest_count'));

            add_shortcode('tweet-count', array($this, 'tweet_count'));

            add_shortcode('google-plus', array($this, 'google_plus_count'));

            add_shortcode('linkedin-share', array($this, 'linkedin_share'));

            add_shortcode('stumbledupon', array($this, 'stumbledupon_share'));
        }

        function get_response_body($url, $type = '')
        {

            $response = wp_remote_get($url);
            $body = wp_remote_retrieve_body($response);

            // if api call is pinterest, make the response pure json
            if ($type == 'pinterest') {
                $body = preg_replace('/^receiveCount\((.*)\)$/', '\\1', $body);
            }

            return json_decode($body);
        }

        function post_response_body($url)
        {

            $query = '
        [{
            "method": "pos.plusones.get",
            "id": "p",
            "params": {"nolog": true, "id": "' . $url . '", "source": "widget", "userId": "@viewer", "groupId": "@self"},
            "jsonrpc": "2.0",
            "key": "p",
            "apiVersion": "v1"
        }]
        ';

            $response = wp_remote_post(
                'https://clients6.google.com/rpc',
                array(
                    'headers' => array('Content-type' => 'application/json'),
                    'body' => $query
                )
            );

            return json_decode(wp_remote_retrieve_body($response), true);
        }

        function facebook_share($atts)
        {
            $url = $atts['url'];
            $api_call = 'http://graph.facebook.com/?id=' . $url;

            return $this->get_response_body($api_call)->shares . ' Facebook Likes & Shares';

        }

        function facebook_page_like($atts)
        {
            $username = $atts['username'];
            $api_call = 'http://graph.facebook.com/?id=http://facebook.com/' . $username;

            return $this->get_response_body($api_call)->likes . ' Facebook Page Like';
        }

        static function get_instance()
        {
            static $instance = false;

            if (!$instance) {
                $instance = new self;
            }

        }

    }
}