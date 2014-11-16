<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function parse_template($object, $body)
{
    if (preg_match_all('/\[(.*?)\]/', $body, $template_vars))
    {
        foreach ($template_vars[1] as $var)
        {
            switch ($var)
            {
                case 'invoice_id':
                    $replace = $object->invoice_id;
                    break;
                case 'invoice_number':
                    $replace = $object->invoice_number;
                    break;
                case 'invoice_total':
                    $replace = $object->invoice_total;
                    break;
                case 'invoice_date_created':
                    $replace = $object->invoice_date_created;
                    break;
                case 'invoice_due_date':
                    $replace = $object->invoice_due_date;
                    break;
				case 'invoice_amount':
                    $replace = $object->invoice_amount;
                    break;
                case 'invoice_total_paid':
                    $replace = $object->invoice_total_paid;
                    break;
                case 'invoice_balance':
                    $replace = $object->invoice_balance;
                    break;
                case 'invoice_terms':
                    $replace = $object->invoice_terms;
                    break;
                case 'invoice_status':
                    $replace = $object->invoice_status;
                    break;
                case 'invoice_payment_method':
                    $replace = $object->invoice_payment_method;
                    break;
				case 'client_name':
                    $replace = $object->client_name;
                    break;
				case 'client_address':
					$replace = $object->client_address;
				break;
				case 'client_city':
					$replace = $object->client_city;
				break;
				case 'client_state':
					$replace = $object->client_state;
				break;
				case 'client_country':
					$replace = $object->client_country;
				break;
                default:
                    $replace = $object->{$var};
            }

            $body = str_replace('[' . $var . ']', $replace, $body);
        }
    }
    return $body;
}
?>