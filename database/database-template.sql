-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26/06/2024 às 17:27
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `jobs_balancebet`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `chats`
--

DROP TABLE IF EXISTS `chats`;
CREATE TABLE IF NOT EXISTS `chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chat_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bot_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `message_conversation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `chats`
--

INSERT INTO `chats` (`id`, `chat_id`, `bot_id`, `last_message`, `message_conversation`, `created_at`, `updated_at`) VALUES
(38, '6991246080', '9', '112', '113', '2024-06-11 18:27:37', '2024-06-11 18:27:38');

-- --------------------------------------------------------

--
-- Estrutura para tabela `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int NOT NULL,
  `nome` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sem-nome',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefone` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vencimento` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_plano` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notas` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `recebe_zap` int DEFAULT NULL,
  `senha` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_painel` int DEFAULT NULL,
  `server_id` int DEFAULT NULL,
  `identificador_externo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `indicado` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `totime` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '20200209',
  `buy` int NOT NULL DEFAULT '0',
  `alert` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `screens` int NOT NULL DEFAULT '1',
  `renovated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=231018 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `customers`
--

INSERT INTO `customers` (`id`, `id_user`, `nome`, `email`, `telefone`, `vencimento`, `id_plano`, `notas`, `recebe_zap`, `senha`, `id_painel`, `server_id`, `identificador_externo`, `indicado`, `totime`, `buy`, `alert`, `screens`, `renovated_at`, `created_at`, `updated_at`) VALUES
(231015, 1, 'sem-nome', 'teste', 'teste', '2024-05-17 16:55:27', '1', 'teste', 1, 'teste', NULL, 1, NULL, '0', '20200209', 0, NULL, 1, '2024-05-17 16:55:27', '2024-05-17 16:55:27', '2024-05-17 16:55:27'),
(231016, 1, 'sem-nome', 'teste', 'teste', '2024-05-17 16:55:27', '1', 'teste', 1, 'teste', NULL, 1, NULL, '0', '20200209', 0, NULL, 1, '2024-04-17 16:55:27', '2024-04-24 16:55:27', '2024-05-17 16:55:27'),
(231017, 1, 'sem-nome', 'teste', 'teste', '2024-05-17 16:55:27', '1', 'teste', 1, 'teste', NULL, 1, NULL, '0', '20200209', 0, NULL, 1, '2024-05-17 16:55:27', '2024-04-24 16:55:27', '2024-05-17 16:55:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `financial`
--

DROP TABLE IF EXISTS `financial`;
CREATE TABLE IF NOT EXISTS `financial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` enum('deposit','withdraw') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'deposit',
  `plan_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `financial`
--

INSERT INTO `financial` (`id`, `id_user`, `value`, `description`, `type`, `plan_id`, `created_at`, `updated_at`) VALUES
(1, 1, '19.5', 'teste financialfinancial financial teste financialfinancial financial ', 'deposit', NULL, '2024-04-05 00:00:00', '2024-06-26 13:51:17'),
(8, 1, '100', 'teste', 'deposit', NULL, '2024-04-18 00:00:00', '2024-05-16 23:13:28'),
(9, 1, '23.44', 'edfdsf', 'withdraw', NULL, '2024-04-10 00:00:00', '2024-05-16 23:13:40'),
(6, 1, '18', 'teste 909090', 'deposit', NULL, '2024-05-14 00:00:00', '2024-05-14 20:31:34'),
(10, 1, '50', 'teste', 'deposit', NULL, '2024-01-01 00:00:00', '2024-05-17 18:31:36'),
(11, 1, '67.8', 'teste', 'deposit', NULL, '2024-02-17 00:00:00', '2024-05-17 19:07:12'),
(12, 1, '30', 'ytyt', 'deposit', NULL, '2024-03-17 00:00:00', '2024-05-17 19:07:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `options_settings`
--

DROP TABLE IF EXISTS `options_settings`;
CREATE TABLE IF NOT EXISTS `options_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `options_settings`
--

INSERT INTO `options_settings` (`id`, `id_user`, `name`, `content`, `created_at`, `updated_at`) VALUES
(23, 1, 'hours_send', '[{\"hour\": \"03:00\", \"hour\": \"10:00\"}]', '2024-04-26 01:16:12', '2024-04-26 01:16:12'),
(39, NULL, 'device_whatsapp', '663e7a3dd74e6_WPPSALES', '2024-05-10 19:49:17', '2024-05-10 19:49:17'),
(38, 1, 'qtd_send_hours', '100', '2024-04-27 05:40:44', '2024-04-27 05:40:44'),
(40, NULL, 'response_not_plans', 'Nenhum plano encontrado para este grupo', '2024-05-27 19:10:38', '2024-05-27 19:10:38'),
(41, NULL, 'text_menu', 'Voltar ao menu', '2024-05-27 19:13:04', '2024-05-27 19:13:04'),
(42, NULL, 'gateways', '[\n  {\n    \"name\": \"mercadopago\", \n    \"title\": \"Mercado Pago\",\n    \"logo\": \"https://seeklogo.com/images/M/mercado-pago-logo-18C70D8C77-seeklogo.com.png?v=638388567980000000\"\n  }\n]', '2024-05-28 19:34:12', '2024-05-28 19:34:12'),
(43, NULL, 'text_options_paymenyt', 'Escolha como você deseja efeturar o pagamento de {{plan_value}}.\n\nPlano: {{plan_name}}\nGrupo: {{group_name}}\n\nApós o pagamento, acesse o grupo através deste link: {{group_invite_link}}\nVocê será aceito apenas após a confirmação do pagamento. \n\nVocê será notificado sobre o status do pagamento por aqui.', '2024-06-04 05:42:43', '2024-06-04 05:42:43'),
(44, NULL, 'email_settings_payment', 'luanalvesnsr@gmail.com', '2024-06-04 07:17:00', '2024-06-04 07:17:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `chat_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `plan_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `group_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_message` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `external_reference` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `payments`
--

INSERT INTO `payments` (`id`, `data`, `chat_id`, `plan_id`, `group_id`, `id_message`, `external_reference`, `created_at`, `updated_at`) VALUES
(22, '{\"id\":79745668960,\"acquirer_reconciliation\":[],\"sponsor_id\":null,\"operation_type\":\"regular_payment\",\"order\":[],\"brand_id\":null,\"build_version\":\"3.54.0\",\"binary_mode\":false,\"external_reference\":\"ac148dea-31ef-4edb-b8ab-7f371f71e2ee\",\"financing_group\":null,\"status\":\"pending\",\"status_detail\":\"pending_waiting_transfer\",\"store_id\":null,\"taxes_amount\":0,\"date_created\":\"2024-06-04T07:31:08.989-04:00\",\"live_mode\":true,\"date_last_updated\":\"2024-06-04T07:31:08.989-04:00\",\"date_of_expiration\":\"2024-06-05T07:31:08.786-04:00\",\"deduction_schema\":null,\"date_approved\":null,\"money_release_date\":null,\"money_release_schema\":null,\"money_release_status\":\"released\",\"currency_id\":\"BRL\",\"transaction_amount\":10,\"transaction_amount_refunded\":0,\"payer\":{\"type\":null,\"id\":\"1579944339\",\"email\":null,\"identification\":{\"type\":null,\"number\":null},\"first_name\":null,\"last_name\":null,\"entity_type\":null,\"phone\":{\"area_code\":null,\"number\":null,\"extension\":null},\"operator_id\":null},\"collector_id\":837458219,\"counter_currency\":null,\"payment_method_id\":\"pix\",\"payment_method\":{\"id\":\"pix\",\"type\":\"bank_transfer\",\"issuer_id\":\"12501\"},\"payment_type_id\":\"bank_transfer\",\"pos_id\":null,\"transaction_details\":{\"financial_institution\":null,\"net_received_amount\":0,\"total_paid_amount\":10,\"installment_amount\":0,\"overpaid_amount\":0,\"external_resource_url\":null,\"payment_method_reference_id\":null,\"acquirer_reference\":null,\"payable_deferral_period\":null,\"bank_transfer_id\":null,\"transaction_id\":null},\"fee_details\":[],\"differential_pricing_id\":null,\"authorization_code\":null,\"captured\":true,\"card\":[],\"call_for_authorize_id\":null,\"statement_descriptor\":null,\"shipping_amount\":0,\"additional_info\":{\"available_balance\":null,\"nsu_processadora\":null,\"authentication_code\":null},\"coupon_amount\":0,\"installments\":1,\"description\":\"1 dia de acesso\",\"notification_url\":null,\"issuer_id\":\"12501\",\"processing_mode\":\"aggregator\",\"merchant_account_id\":null,\"merchant_number\":null,\"metadata\":[],\"callback_url\":null,\"marketplace_owner\":null,\"integrator_id\":null,\"corporation_id\":null,\"platform_id\":null,\"point_of_interaction\":{\"type\":\"OPENPLATFORM\",\"application_data\":{\"name\":null,\"version\":null},\"transaction_data\":{\"qr_code\":\"00020126360014br.gov.bcb.pix0114+5545999422339520400005303986540510.005802BR5911OLRO29623466015Nova Santa Rosa62240520mpqrinter7974566896063048A04\",\"qr_code_base64\":\"iVBORw0KGgoAAAANSUhEUgAABRQAAAUUAQAAAACGnaNFAAANwUlEQVR4Xu3ZW3Iktw5F0ZyB5z9Lz6AcQgI8eDB1byjoVsna56OaJEBwpX77er19\\/r76yfsF45lgPBOMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgm2Xj1\\/LXOYvVx4d5q5YUY0EZ5X6za1lcPj3sw2hYjRowYPRjLKIwYMd5bjBfGNupXGnWubUF5KVbNmN0xSo\\/KqEIbpWDEuG\\/DiHG1+GNRwLhvw4hxtfhjUcC4b8OIcbX4Y1HAuG97Q6MP1Dvl2daS3ZE84NrINDSigh+Uj8Ro\\/2LEmKKCH2B8YXxqw3i3RMEPML4wPrVhvFui4AcYXxif2n6CMQqe8li+EdeyO3i5oK1aXp88jnGgMD7OxBgta\\/nc9slMjNGyls9tn8zEGC1r+dz2yUyM0bKWz22fzMQYLWv53PbJTIzRspbPbZ\\/MxBgta\\/nc9slMjNGylts2bfPbai6f4c0acO21+S5GjBjTgAvj2GLsr2HMAy6MY4uxv4YxD7gwji3G\\/tqPN7ZtnmRPxLO+bttC1mo3SuR2Y2wxxmo3CqNXI3k7X8S4GzxQbTtfxLgbPFBtO1\\/EuBs8UG07X8S4GzxQbTtfxLgbPFBtO1\\/EuBs8UG07X8S4GzxQbTtf\\/JXGljL9X\\/+Zj2P8ys98HONXfubjGL\\/yMx\\/H+JWf+TjGr\\/zMxzF+5Wc+jvErP\\/NxjF\\/5mY9j\\/MrPfPyHGj+Pbvu2PKGz1ux5KLRr+2BUHgrt2j4YlYdCu7YPRuWh0K7tg1F5KLRr+2BUHgrt2j4YlYdCu7YPRuWh0K7tg1F5KLRr+2BUHgrt2j4\\/zxj\\/S5SH2H\\/3vJan5eFtS7vrW\\/3PUVQ9j\\/+lhBFjBON8HOMMRgXjfBzjDEYF43wc4wxG5d2MeboitxnL9FbYfUZDPU7JVQvGEowejGsKRozWt5YY16iHKRgxWt9aYlyjHqZgxGh9a\\/lzjG1be8skPabEB+mkPTuqKuzmWTC+MGJUVYXdPAvGF0aMqqqwm2fB+MKIUVUVdvMsGF8Y39ToirLymUWWEyjvsxvWMkd5VfPKjfwtlvy3WUvb9cE+CSNGjB6M0RLdGP0WRox3\\/AbGOdgnYcSI0fPTjKr7Nrfdt1T9RBFGjz7N+tqP3bChcbb5O2i9pmLEiBEjRox3MGLEuM7G6oUR428y7tsaRdWyGtDIGBDV3bx8NwvW0nYYMW6qGDF+xN+5MNazXRUjxo\\/4OxfGerarYsT4EX\\/nwljPdtVvMeZz20avflTw6Yqqs1l5\\/BZVGwNjnhLBiDFVMXp1NisYMaYqRq\\/OZgUjxlTF6NXZrGB8F6Pa2sp759nM+JYSneVV+TuMaxhnn87yCuMMRi9iXGd5hXEGoxcxrrO8wjiD0YsY11leYZz5d43K6C2yoTB8uaYX2zf7xfa5sc0\\/CkaMGDGuqq\\/K2xhbMN5no4ARI0aMGP\\/jxv81qUWyqHpnyebFXtC3aKu\\/A0YLRowYIxgx1mDEiDGCEWPNrzTOXp8Zt3JLwedno5CvRdqfIL9hKYLVpzXGOxgxRjDaCuMLYwQjxghGW2F8YYz8DmO0ea\\/OrjpYEUA3YpU\\/o3z4+NLyJ2jzMGLEiPGFEeO98hsYo4gR4wsjxnvlNzDG1dam7f\\/1BZrS3AHNPLsb2\\/yjYMRowYixFy6MGDFaMGLshQsjxt9pXEfl2VemNJ6vy2Nq0WPZGC0aMKpR8GDEWNr8wIJx8zhGjK3NDywYN49jxNja\\/MCCcfM4RoytzQ8s327UE21VxuWZdqaUx0b1qm9bdb6RCxaMrXphxIjRzhSMvrswYsQ4qhgxDtm8j\\/E\\/Y\\/SjfkHPKrlZ7pej4t5+6yk3dJZ5FowPWw9GVTHewfiw9WBUFeMdjA9bD0ZVMd7B+LD1YFT1m4wvb8uT5A6t98VZHly+JT+ra0MRA6IlB6MFYzyB8S5gxGhn\\/eQjGDFi9FUt2Vk\\/+QhGjBh9VUt21k8+8r7G3FZ67Sm1+FZuS3lHMm8qqPaQT9G1dgPj7sXXeMinYLRgjGBMwYgxrrUbGHcvvsZDPgWjBWMEYwrGNzA+ZoffUWak0PaTJ8u3eDBeGGswpmB8CMYcjCkYH4IxB2MKxodgzHkbo+6rVwC1tHHa7q81lD6orMY1BaNdwxirfAtjf82C0a5hjFW+hbG\\/ZsFo1zDGKt\\/C2F+zYLRrGGOVb32zUUW9uDvLW6sW9yjozO7uyPOaWjBiHLfKWd6KYpmPYcRYpsxrasGIcdwqZ3krimU+hhFjmTKvqQUjxnGrnOWtKJb52C80KpkSyVVtbVzMfLwmnijtc3VNfR6M0YfRx9lVVbXFeAdj9GH0cXZVVW0x3sEYfRh9nF1VVVuMdzBGH0YfZ1dV1fZPG\\/OkmVbQdn\\/jAWX\\/+nvxfS3LE8GIcQZjyvJEMGKcwZiyPBGMGGcwpixPBCPGmfcwtpl24o+1xHTbeHPc1ZmgutZasrF9i97FiPHCGC0YMWK8o8cw2glGjBgxeoMe+63GfOtalDhrnzFW+r7maR8eLXlbVjkYMUYwdplWORgxRjB2mVY5GDFGMHaZVjkYMUbez+hHd3bbNsRLwRsya46PzNeipX19Pssta6mjuDW3uRBbjLZdSx3FrbnNhdhitO1a6ihuzW0uxBajbddSR3FrbnMhthhtu5Y6iltzmwuxxWjbtdRR3JrbXIgtRtuupY7i1tzmQmwx2nYtdRS35jYXYovRtmupo7g1t7kQW4y2XUsdxa25zYXY\\/mFjFP2eVrHVJB1nRTMKHzeadqTx\\/Kzu7g5\\/HeM2GDHm3d3hr2PcBiPGvLs7\\/HWM22DEmHd3h7+OcRuMf8oYyW0FpTNPKNZBz26KZ\\/cnsBaMM7spHowYMW6ym+LBiBHjJrspHowYMW6ym+LB+H3G\\/OLu7cezq+LtifiMtsotkTY5lywYrYBx59mdXRgxWgHjzrM7uzBitALGnWd3dmHEaAWMO8\\/u7PpzRg3xn1LIQ9o7oRDPjr25rHwbqN2T7QswenNZ+RajPYYRI8bY9QsqYMQYVQtG3\\/ULKmDEGFULRt\\/1Cyq8h1FX9aIutNUgR7ypQFu8JUa1bWvB6M0z3hKj2ra1YPTmGW+JUW3bWjB684y3xKi2bS0YvXnGW2JU27YWjN484y0xqm1bC0ZvnvGWGNW2rQWjN894S4xq29aC0ZtnvCVGtW1rwejNM94So9q2tfxYoybZO\\/HTxuXI2D7yylBN8ZLNm9\\/X\\/jYYLdbgK4wYV7wZI0YVdQEjxh6MGD9iDb7CiHHFm3+4cR3FuLhl0fT82BhXHotmVfPnlin5RgvGaFYVI8Y7upuDMZpVxYjxju7mYIxmVTFivKO7ORijWVWMb2TMbW1mnDVtvhbG3KKUZq8Wcq7mJ9fyjl+1YLyrGK0PY1xbyzt+1YLxrmK0PoxxbS3v+FULxruK0fowxrW1vONXLRjvKkbr+9NGXVWb\\/fuobeSRBo0ba8TLWzR0F4wYLRg\\/ghFjCUaMFowfwYixBOOvNhZZG5I9dhYvqq8V9qhI\\/tIY6gUFowUjxvUGRowRjBaMGNcbGDFGMFp+ndGSH4tbuyEDf9WvUvTsZ2690aoYc19UvR0jxt5nwai+qHo7Roy9z4JRfVH1dowYe58Fo\\/qi6u0Yv92oJ+JWGyyU4qOVYsydn4335vLHWNfW0nbPQzBixHj3raXtnodgxIjx7ltL2z0PwYgR4923lrZ7HoIR4581tvu1LcaVmZbVFHdjlX\\/UrG\\/WjZjsaX8HjBgx9hsYr82LscKIcd7AeG1ejBVGjPMGxmvzYqwwvrNRKY\\/lapnpJT3x+fe98pSMf\\/zbWDCWqm00BSPGcteCsVRtoykYMZa7FoylahtNwYix3LVgLFXbaArG7zS22O18UN7JZw2wiz5NA8LT+ryqYFQwKhhXn1cVjApGBePq86qCUcGoYFx9XlUwKhiVNzRa8tV4x4eUJ7T1a6Xgp\\/FBHs3TtSjoDKMKfooRI0aM69pabjNuYVwFjH4NY8m4hXEVMPo1jCXj1jcb1+VI9Grrfa1wVXK54dUYr9fGqHI3N2HEaJkveh\\/G3ocRo2W+6H0Yex9GjJb5ovdh7H0YMVrmi973ncZQaDt+7H7xtBu+stj27\\/xiPotCvlZe82DEGNvxgxHjuuErjGU7fjBiXDd8hbFsxw9GjOuGrzCW7fh5B6Omt94GaO+4W5nP6oYlV0v0J\\/BgjGsYMWLE+PEPxhigaxgxYsT48Q\\/GGKBrGNu2ofyaDd7l8TMKuY3KPAtGjBgxYsxVBSNGjBgx5qqCEWMzljM1+7NaRV9+tgz1xLX917dgnEM9GDFug3EO9WDEuA3GOdSDEeM2GOdQD8Z3MLbtoKh65ZlDZlXb6u2y2n1u3ioYMcYW451xFyPG1yhixBhVjCkYMcYW451x98cbW8TTNvryi3ZmH1T6WnVsG1lDy2SMrTq2GK8xCaPW3qhgxPgRjBhTX6uOLcZrTMKotTcqGDF+5JuM7xqMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgmGM8E45lgPBOMZ4LxTDCeCcYzwXgmGM8E45n8COM\\/VbRJ+lkzpA0AAAAASUVORK5CYII=\",\"transaction_id\":null,\"bank_transfer_id\":null,\"financial_institution\":null,\"bank_info\":{\"payer\":{\"id\":null,\"account_id\":null,\"long_name\":null,\"external_account_id\":null,\"identification\":[]},\"collector\":{\"account_id\":null,\"long_name\":null,\"account_holder_name\":\"Romalina Oliveira da Rosa\",\"transfer_account_id\":null},\"is_same_bank_account_owner\":null,\"origin_bank_id\":null,\"origin_wallet_id\":null},\"ticket_url\":\"https:\\/\\/www.mercadopago.com.br\\/payments\\/79745668960\\/ticket?caller_id=1579944339&hash=025ba99a-6ff1-42de-a78e-579e0bca010e\",\"e2e_id\":null}},\"accounts_info\":null,\"tags\":null,\"refunds\":[]}', '6991246080', '1', '5', '79745668960', 'ac148dea-31ef-4edb-b8ab-7f371f71e2ee', '2024-06-04 08:31:06', '2024-06-04 08:31:07');

-- --------------------------------------------------------

--
-- Estrutura para tabela `plataforms`
--

DROP TABLE IF EXISTS `plataforms`;
CREATE TABLE IF NOT EXISTS `plataforms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bot_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apikey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `payment_settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `plataforms`
--

INSERT INTO `plataforms` (`id`, `bot_id`, `name`, `apikey`, `username`, `payment_settings`, `created_at`, `updated_at`) VALUES
(9, 2147483647, 'Plataforma de teste', '6512773027:AAGyy10mG3iNoqTHwmZJFJyHI4__18E4hwo', 'bottelegramphp', '{\"mercadopago\":{\"split\":{\"access_token\":\"\",\"expire_access_token\":\"\",\"refresh_token\":\"\",\"pin\":{\"expire\":1717499271,\"number\":363930},\"enable\":\"1\",\"percent\":\"3\"},\"title\":\"Mercado Pago\",\"enable\":\"1\",\"data\":{\"access_token\":\"APP_USR-1769606458828443-122617-bbd657b7f227fbfdb9ab12b54c2c789c-837458219\"},\"methods\":{\"pix\":{\"enable\":\"1\",\"text\":\"Pagar com pix\"},\"link\":{\"enable\":\"0\",\"text\":\"Pagar com cartão\"}}}}', '2024-05-25 21:40:27', '2024-06-04 07:07:51');

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin` int NOT NULL DEFAULT '0',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `csrf_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `user`
--

INSERT INTO `user` (`id`, `admin`, `username`, `password`, `csrf_token`, `updated_at`, `created_at`) VALUES
(1, 0, 'admin', '$2y$10$E9OZXvtC4EmOP2wmjw7Beu27wwkl8vq9BaCBLVTClZiKVJu7nOUm2', 'c438e728e20c1e553e353486f35d1f7ec857c3f2826fc2c17b150bb9b2d6d6dd', '2024-06-26 13:57:52', '2024-03-13 19:31:07');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
