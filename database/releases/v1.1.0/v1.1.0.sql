 alter table `payments` add `stripe_id` varchar(191) null after `send_mail_to_customer_contacts`, add `meta` text null after `stripe_id`;

 insert into `payment_modes` (`name`, `active`, `updated_at`, `created_at`) values ('Stripe', true, '2020-01-11 00:00:00', '2020-01-11 00:00:00');
