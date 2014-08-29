#
# Table structure for table 'tx_t3booking_domain_model_booking'
#
CREATE TABLE tx_t3booking_domain_model_booking (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	start_at int(11) DEFAULT '0' NOT NULL,
	status int(11) DEFAULT '0' NOT NULL,
	end_at int(11) DEFAULT '0' NOT NULL,
	quantity int(11) DEFAULT '0' NOT NULL,
	user int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid),

);

#
# Table structure for table 'tx_t3booking_domain_model_booking'
#
CREATE TABLE tx_t3booking_domain_model_booking (
	categories int(11) unsigned DEFAULT '0' NOT NULL,
);
