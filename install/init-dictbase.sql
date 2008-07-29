INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (1,'string','OEM S/N 1');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (2,'dict','HW type');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (3,'string','FQDN');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (4,'dict','SW type');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (5,'string','SW version');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (6,'uint','number of ports');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (7,'float','max. current, Ampers');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (8,'float','power load, percents');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (14,'string','contact person');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (13,'float','max power, Watts');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (16,'uint','flash memory, MB');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (17,'uint','DRAM, MB');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (18,'uint','CPU, MHz');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (20,'string','OEM S/N 2');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (21,'string','support contract expiration');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (22,'string','HW warranty expiration');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (24,'string','SW warranty expiration');
INSERT INTO `Attribute` (`attr_id`, `attr_type`, `attr_name`) VALUES (25,'string','UUID');

INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,1,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,2,11);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,3,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,4,13);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,14,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,21,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,22,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,25,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (4,24,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (5,1,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (5,2,18);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (6,1,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (6,2,19);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (6,20,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,1,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,2,17);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,3,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,4,16);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,5,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,14,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,16,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,17,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,18,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,21,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,22,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (7,24,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,1,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,2,12);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,3,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,4,14);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,5,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,14,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,16,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,17,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,18,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,20,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,21,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,22,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (8,24,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (9,6,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (12,1,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (12,3,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (12,7,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (12,8,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (12,13,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (12,20,0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (445, 1, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (445, 2, 21);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (445, 3, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (445, 5, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (445, 14, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (445, 22, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (447, 1, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (447, 2, 22);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (447, 3, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (447, 5, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (447, 14, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (447, 22, 0);
INSERT INTO `AttributeMap` (`objtype_id`, `attr_id`, `chapter_no`) VALUES (15, 2, 23);

INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (11,'no','server models');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (12,'no','network switch models');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (13,'no','server OS type');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (14,'no','switch OS type');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (1,'yes','RackObjectType');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (2,'yes','PortType');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (3,'yes','RackRow');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (16,'no','router OS type');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (17,'no','router models');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (18,'no','disk array models');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (19,'no','tape library models');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (21,'no','KVM switch models');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (22,'no','multiplexer models');
INSERT INTO `Chapter` (`chapter_no`, `sticky`, `chapter_name`) VALUES (23, 'no', 'console models');

INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (17,17);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (18,18);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (19,19);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (20,20);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (21,21);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (22,22);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (23,23);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (24,24);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (25,25);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (26,26);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (27,27);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (28,28);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (18,19);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (19,18);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (18,24);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (24,18);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (19,24);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (24,19);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (29,29);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (20,21);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (21,20);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (22,23);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (23,22);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (25,26);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (26,25);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (27,28);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (28,27);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (30,30);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (16,16);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (17,17);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (18,18);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (19,19);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (20,20);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (21,21);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (22,22);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (23,23);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (24,24);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (25,25);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (26,26);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (27,27);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (28,28);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (18,19);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (19,18);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (18,24);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (24,18);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (19,24);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (24,19);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (29,29);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (29,681);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (29,682);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (20,21);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (21,20);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (22,23);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (23,22);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (25,26);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (26,25);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (27,28);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (28,27);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (30,30);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (16,16);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (32,32);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (33,446);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (34,34);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (35,35);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (36,36);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (37,37);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (38,38);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (39,39);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (40,40);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (41,41);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (439,439);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (446,33);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (681,29);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (681,681);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (681,682);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (682,29);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (682,681);
INSERT INTO `PortCompat` (`type1`, `type2`) VALUES (682,682);

INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,1,'BlackBox');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,2,'PDU');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,3,'Shelf');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,4,'Server');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,5,'DiskArray');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,6,'TapeLibrary');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,7,'Router');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,8,'network switch');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,9,'PatchPanel');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,10,'CableOrganizer');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,11,'Placeholder');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,12,'UPS');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,13,'Modem');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,14,'MediaConverter');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,15,'console');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,16,'power plug');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,17,'BNC/10Base2');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,18,'RJ-45/10Base-T');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,19,'RJ-45/100Base-TX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,20,'SC/100Base-FX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,21,'LC/100Base-FX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,22,'SC/100Base-SX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,23,'LC/100Base-SX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,24,'RJ-45/1000Base-T');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,25,'SC/1000Base-SX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,26,'LC/1000Base-SX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,27,'SC/1000Base-LX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,28,'LC/1000Base-LX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,29,'async serial (RJ-45)');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,30,'LC/10GBase-SR');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,31,'veth (Xen bridge)');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,32,'sync serial');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,33,'KVM (host)');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,34,'1000Base-ZX');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,35,'10GBase-ER');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,36,'10GBase-LR');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,37,'10GBase-LRM');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,38,'10GBase-ZR');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,39,'10GBase-LX4');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,40,'10GBase-CX4');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,41,'10GBase-Kx');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,439,'dry contact');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,440,'unknown');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,445,'KVM switch');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,446,'KVM (console)');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (1,447,'multiplexer');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,681,'async serial (DB-9)');
INSERT INTO `Dictionary` (`chapter_no`, `dict_key`, `dict_value`) VALUES (2,682,'async serial (DB-25)');

INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('rtwidth_0','9','uint','no','yes','');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('rtwidth_1','21','uint','no','yes','');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('rtwidth_2','9','uint','no','yes','');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('color_F','8fbfbf','string','no','yes','HSV: 180-25-75. Free atoms, they are available for allocation to objects.');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('color_A','bfbfbf','string','no','yes','HSV: 0-0-75. Absent atoms.');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('color_U','bf8f8f','string','no','yes','HSV: 0-25-75. Unusable atoms. Some problems keep them from being free.');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('color_T','408080','string','no','yes','HSV: 180-50-50. Taken atoms, object_id should be set for such.');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('color_Th','80ffff','string','no','yes','HSV: 180-50-100. Taken atoms with highlight. They are not stored in the database and are only used for highlighting.');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('color_Tw','804040','string','no','yes','HSV: 0-50-50. Taken atoms with object problem. This is detected at runtime.');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('color_Thw','ff8080','string','no','yes','HSV: 0-50-100. An object can be both current and problematic. We run highlightObject() first and markupObjectProblems() second.');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('default_port_type','24','uint','no','no','Default port type');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('MASSCOUNT','15','uint','no','no','&quot;Fast&quot; form is this many records tall');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('MAXSELSIZE','30','uint','no','no','&lt;SELECT&gt; lists height');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('enterprise','MyCompanyName','string','no','no','Organization name');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('NAMEFUL_OBJTYPES','4,7,8','string','yes','no','Expect common name configured for the following object types');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('ROW_SCALE','2','uint','no','no','Picture scale for rack row display');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('PORTS_PER_ROW','12','uint','no','no','Ports per row in VLANs tab');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('IPV4_ADDRS_PER_PAGE','256','uint','no','no','IPv4 addresses per page');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('DEFAULT_RACK_HEIGHT','42','uint','yes','no','Default rack height');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('REQUIRE_ASSET_TAG_FOR','4,7,8','string','yes','no','Require asset tag for the following object types');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('DEFAULT_SLB_VS_PORT','','uint','yes','no','Default port of SLB virtual service');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('DEFAULT_SLB_RS_PORT','','uint','yes','no','Default port of SLB real server');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('IPV4_PERFORMERS','1,4,7,8,12,14,445,447','string','yes','no','IPv4-capable object types');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('NATV4_PERFORMERS','4,7,8','string','yes','no','NATv4-capable object types');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('USER_AUTH_SRC','database','string','no','no','User authentication source');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('DETECT_URLS','no','string','yes','no','Detect URLs in text fields');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('RACK_PRESELECT_THRESHOLD','1','uint','no','no','Rack pre-selection threshold');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('DEFAULT_IPV4_RS_INSERVICE','no','string','no','no','Inservice status for new SLB real servers');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('AUTOPORTS_CONFIG','4 = 1*33*kvm + 2*24*eth%u;15 = 1*446*kvm','string','yes','no','AutoPorts configuration');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('DEFAULT_OBJECT_TYPE','4','uint','yes','no','Default object type for new objects');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('SHOW_EXPLICIT_TAGS','yes','string','no','no','Show explicit tags');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('SHOW_IMPLICIT_TAGS','yes','string','no','no','Show implicit tags');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('SHOW_AUTOMATIC_TAGS','no','string','no','no','Show automatic tags');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('IPV4_AUTO_RELEASE','1','uint','no','no','Auto-release IPv4 addresses on allocation');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('SHOW_LAST_TAB','no','string','yes','no','Remember last tab shown for each page');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('COOKIE_TTL','1209600','uint','yes','no','Cookies lifetime in seconds');
INSERT INTO `Config` (varname, varvalue, vartype, emptyok, is_hidden, description) VALUES ('DB_VERSION','0.16.0','string','no','yes','Database version.');

INSERT INTO `Script` VALUES ('RackCode','allow {$userid_1}');
