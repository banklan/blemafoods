<?php

namespace App\Http\Controllers;

use Paystack;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Client;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public function redirectToGateway()
    {
        // $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
        // $client = new \GuzzleHttp\Client();
        // $url = 'http://127.0.0.1:3000/pay';
        // $request = $client->request('GET', $url, ['verify' => 'C:\wamp64\bin\php\php7.2.14\extras\ssl\cacert.pem']);
         return Paystack::getAuthorizationUrl()->redirectNow();

        //     **
        //  *  This fluent method does all the dirty work of sending a POST request with the form data
        //  *  to Paystack Api, then it gets the authorization Url and redirects the user to Paystack
        //  *  Payment Page. I abstracted all of it, so you don't have to worry about that.
        //  *  Just eat your cookies while coding!
        //  */
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        /**
         * This fluent method does all the dirty work of verifying that the just concluded transaction was actually valid,
         * It verifies the transaction reference with Paystack Api and then grabs the data returned from Paystack.
         * In that data, we have a lot of good stuff, especially the `authorization_code` that you can save in your db
         * to allow for easy recurrent subscription.
         */

        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }

    public function getAllTransactionsCustomers()
    {
        $customers = Paystack::getAllCustomers();

        /**
         * This method gets all the customers that have performed transactions on your platform with Paystack
         * @returns array
         */
    }

    public function getAllPlans()
    {
        $plans = Paystack::getAllPlans();

        /**
         * This method gets all the plans that you have registered on Paystack
         * @returns array
         */
    }

    public function getAllTransactions()
    {
        $transactions = Paystack::getAllTransactions();

        /**
         * This method gets all the transactions that have occurred
         * @returns array
         */
    }

    public function generateTranxRef()
    {
        $ref = Paystack::genTranxRef();

         /**
         * This method generates a unique super secure cryptograhical hash token to use as transaction reference
         * @returns string
         */
    }

    public function createSubAccount()
    {
        Paystack::createSubAccount();

        /**
        * This method creates a subaccount to be used for split payments
        * @return array
        */
    }

    public function fetchSubAcctDetails(Type $var = null)
    {
        /**
        * This method fetches the details of a subaccount
        * @return array
        */
        Paystack::fetchSubAccount();
    }

    public function listSubAccounts()
    {
        /**
        * This method lists the subaccounts associated with your paystack account
        * @return array
        */
        Paystack::listSubAccounts();
    }

    public function updateSubAccount()
    {
         /**
        * This method Updates a subaccount to be used for split payments
        * @return array
        */
        Paystack::updateSubAccount();
    }
}
