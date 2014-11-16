-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 16 2014 г., 16:13
-- Версия сервера: 5.5.37-0ubuntu0.13.10.1
-- Версия PHP: 5.5.3-1ubuntu2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: 'invoicer'
--

-- --------------------------------------------------------

--
-- Структура таблицы 'api'
--

CREATE TABLE api (
  api_id int(11) NOT NULL AUTO_INCREMENT,
  api_name varchar(255) NOT NULL,
  shop_id int(11) NOT NULL,
  where_used varchar(255) NOT NULL,
  api_type enum('email','iframe') NOT NULL DEFAULT 'email',
  recurrent enum('0','1') DEFAULT '0',
  recurrent_days int(11) NOT NULL,
  api_key varchar(255) NOT NULL,
  email text NOT NULL,
  iframe text NOT NULL,
  PRIMARY KEY (api_id)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_businesses'
--

CREATE TABLE ci_businesses (
  business_id int(11) NOT NULL AUTO_INCREMENT,
  business_name varchar(200) NOT NULL,
  user_id int(11) NOT NULL,
  address varchar(200) NOT NULL,
  fax varchar(200) NOT NULL,
  email varchar(200) NOT NULL,
  phone varchar(200) NOT NULL,
  currency varchar(200) NOT NULL,
  logo varchar(200) NOT NULL,
  website varchar(200) NOT NULL,
  PRIMARY KEY (business_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_clients'
--

CREATE TABLE ci_clients (
  client_id int(11) NOT NULL AUTO_INCREMENT,
  client_name varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  client_address varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  client_city varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  client_phone varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  client_fax varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  client_email varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  business int(11) NOT NULL,
  client_date_created datetime NOT NULL,
  PRIMARY KEY (client_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_config'
--

CREATE TABLE ci_config (
  config_id int(11) NOT NULL AUTO_INCREMENT,
  config_name varchar(50) NOT NULL,
  config_value longtext NOT NULL,
  PRIMARY KEY (config_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_invoices'
--

CREATE TABLE ci_invoices (
  invoice_id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  client_id int(11) NOT NULL,
  shop_id int(11) NOT NULL,
  invoice_status enum('PAID','UNPAID','CANCELLED') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'UNPAID',
  invoice_number varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  invoice_discount double NOT NULL,
  invoice_terms longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (invoice_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_invoice_items'
--

CREATE TABLE ci_invoice_items (
  item_id int(11) NOT NULL AUTO_INCREMENT,
  invoice_id int(11) NOT NULL,
  item_quantity decimal(10,2) NOT NULL,
  item_description longtext COLLATE utf8_unicode_ci NOT NULL,
  item_order int(11) NOT NULL,
  item_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  item_price decimal(10,2) NOT NULL,
  item_discount double NOT NULL,
  PRIMARY KEY (item_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_payments'
--

CREATE TABLE ci_payments (
  payment_id int(11) NOT NULL AUTO_INCREMENT,
  invoice_id int(11) NOT NULL,
  payment_method varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  payment_amount decimal(10,2) NOT NULL,
  payment_note longtext COLLATE utf8_unicode_ci NOT NULL,
  payment_date date NOT NULL,
  payment_status enum('pending','completed','cancelled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  PRIMARY KEY (payment_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_payment_transactions'
--

CREATE TABLE ci_payment_transactions (
  transaction_id int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  phone varchar(255) NOT NULL,
  sum double NOT NULL,
  recurrent enum('0','1') NOT NULL,
  paymentDatetime varchar(255) NOT NULL,
  shopSumBankPaycash varchar(255) NOT NULL,
  requestDatetime varchar(255) NOT NULL,
  merchant_order_id varchar(255) NOT NULL,
  customerNumber varchar(255) NOT NULL,
  sumCurrency varchar(255) NOT NULL,
  cdd_pan_mask varchar(255) NOT NULL,
  shopSumAmount varchar(255) NOT NULL,
  ErrorTemplate varchar(255) NOT NULL,
  shopSumCurrencyPaycash varchar(255) NOT NULL,
  orderSumAmount varchar(255) NOT NULL,
  shn varchar(255) NOT NULL,
  shopId varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  shopArticleId varchar(255) NOT NULL,
  orderSumCurrencyPaycash varchar(255) NOT NULL,
  skr_sum varchar(255) NOT NULL,
  orderSumBankPaycash varchar(255) NOT NULL,
  external_id varchar(255) NOT NULL,
  invoiceId varchar(255) NOT NULL,
  paymentType varchar(255) NOT NULL,
  cdd_rrn varchar(255) NOT NULL,
  orderCreatedDatetime varchar(255) NOT NULL,
  paymentPayerCode varchar(255) NOT NULL,
  rebillingOn varchar(255) NOT NULL,
  depositNumber varchar(255) NOT NULL,
  yandexPaymentId varchar(255) NOT NULL,
  skr_env varchar(255) NOT NULL,
  orderNumber varchar(255) NOT NULL,
  payment_status enum('pending','completed') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (transaction_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_products'
--

CREATE TABLE ci_products (
  product_id int(11) NOT NULL AUTO_INCREMENT,
  product_name varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  product_description longtext COLLATE utf8_unicode_ci NOT NULL,
  product_unitprice decimal(10,2) NOT NULL,
  business int(11) NOT NULL,
  PRIMARY KEY (product_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_shops'
--

CREATE TABLE ci_shops (
  shop_id int(11) NOT NULL AUTO_INCREMENT,
  shop_name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  scid varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  shoppw varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  shop_phone varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  shop_email varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  shop_address varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  shop_description text COLLATE utf8_unicode_ci NOT NULL,
  shop_logo varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  payment_shop_id int(11) NOT NULL,
  business int(11) NOT NULL,
  manager int(11) NOT NULL,
  ymoney enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  credit_card enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  mobile_phone enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  kiosks enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  webmoney enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (shop_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы 'ci_users'
--

CREATE TABLE ci_users (
  user_id int(11) NOT NULL AUTO_INCREMENT,
  first_name varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  last_name varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  user_email varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  user_phone varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  username varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  user_date_created date NOT NULL,
  user_level enum('1','2') COLLATE utf8_unicode_ci NOT NULL DEFAULT '2',
  created_by int(11) NOT NULL,
  PRIMARY KEY (user_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы 'payment_pages'
--

CREATE TABLE payment_pages (
  page_id int(11) NOT NULL AUTO_INCREMENT,
  page_name varchar(255) NOT NULL,
  description mediumtext NOT NULL,
  image varchar(255) NOT NULL,
  sum mediumtext NOT NULL,
  recurrent enum('0','1') NOT NULL DEFAULT '0',
  goods_name varchar(255) NOT NULL,
  shop_id int(11) NOT NULL,
  user_change_sum enum('0','1') NOT NULL DEFAULT '0',
  page_unique_id varchar(200) NOT NULL,
  PRIMARY KEY (page_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
