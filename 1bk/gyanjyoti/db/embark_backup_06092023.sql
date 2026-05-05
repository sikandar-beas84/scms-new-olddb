/*
 Navicat Premium Data Transfer

 Source Server         : MySQL Local
 Source Server Type    : MySQL
 Source Server Version : 100425 (10.4.25-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : embark

 Target Server Type    : MySQL
 Target Server Version : 100425 (10.4.25-MariaDB)
 File Encoding         : 65001

 Date: 06/09/2023 13:37:19
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for account_type_master
-- ----------------------------
DROP TABLE IF EXISTS `account_type_master`;
CREATE TABLE `account_type_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of account_type_master
-- ----------------------------
INSERT INTO `account_type_master` VALUES (1, 'Savings Account', 'Y', '2023-05-02 12:04:51', 0, '2023-05-02 12:04:51', NULL);
INSERT INTO `account_type_master` VALUES (2, 'Current Account', 'Y', '2023-05-02 12:04:51', NULL, '2023-05-02 12:04:51', NULL);
INSERT INTO `account_type_master` VALUES (3, 'Loan Account', 'Y', '2023-05-02 12:04:51', NULL, '2023-05-02 12:04:51', NULL);
INSERT INTO `account_type_master` VALUES (4, 'Salary Account', 'Y', '2023-05-02 14:24:13', NULL, '2023-05-02 14:24:13', NULL);

-- ----------------------------
-- Table structure for bank_settings
-- ----------------------------
DROP TABLE IF EXISTS `bank_settings`;
CREATE TABLE `bank_settings`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `bank_name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_code` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_email` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_pincode` varchar(7) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_address` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_mobile` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_fax` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_gstn` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `bank_pan` varchar(12) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bank_settings
-- ----------------------------
INSERT INTO `bank_settings` VALUES (1, 'Bank Name', 'BANK001', 'bank@bank.co.in', '713213', 'Benachity, Durgapur', '9999999999', '8888888888', 'GSTN00125666', 'CDPSSS0614S', 'Y', '2023-06-21 09:50:21', 4, NULL, NULL);
INSERT INTO `bank_settings` VALUES (2, 'Bank Name1', 'Bank Name1', 'bank@bank.co.in', '713213', 'Benachity, Durgapur', '9999999999', '8888888888', 'GSTN00125666', 'CDPSSS0614S', 'Y', '2023-06-21 15:24:44', 4, NULL, NULL);

-- ----------------------------
-- Table structure for branch_masters
-- ----------------------------
DROP TABLE IF EXISTS `branch_masters`;
CREATE TABLE `branch_masters`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `branch_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `branch_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pincode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gstn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of branch_masters
-- ----------------------------
INSERT INTO `branch_masters` VALUES (1, '5a74da4576f397268506fe0bd93ce4e52c187731fc0e34fe245fc9ae343a88587389711f31dc2b5ea8d3d465ce436450184271ce0b0eeb32b27accc5b831d178A5Pnt+EbudVa6XWwYqjPK6Exa320O/5Lb8DobMqF3/Q=', '2e417c1e16ddf42dbcf6a637e268ad809b06c59b00ac35f8153ab4734be83666b892868057cb28f655703855d1c6303a11a4de50ffb5206bbfc6ed0a9698fed8wAEFRDF4QYyzetULfYgEKtYtOjUTTF6bchRzVMISE6w=', '730ddf8ad0c5c2778eaa65c0f16f680d2023b76c035829ec298166cf48dc386d803f16db44401dc494ae947287f8fcdf50c9ead48b293444bb236cbc7f6c4b3fqeFP3o1uUx2He10QOS0Gf4sWlmzMk5Ad/LdHI0cDdnk=', 'f47f54ba735e9669c1c340d885bec5d9ec27f5a555e794d418c71fb831c8187636315795c950386c7b71dfa65ea99830bbd4b5af552eaaa19dcf35b036417c8bLd7qL5Txs7Xm33Gu6RVWN7mmBl3qj7ka2uPiMjomEgk+ckgWE+5+flhAoGsQltJX', '00b98b3b79d7557c46c9670b36ae051b9dca558c54b5af37c83a96a010a8927b86b89c1c62c69c787a1916d592a1800b809f03696e23cbd74e5b5b1aeb5bed59cIlTFhP87gl/KQ7LsT/Mv/On2uLCDQMW2f8NChJ+3Qk=', '18b0654e02e5625df8da290fcc73de5c077b7f0a19032cc182f549e33398d4f56034dcfdc95ccad3961cc5679c998c7dbbc7692e2100e51071d890b99fc2abb2zYQF9GU00rET5COXktri+hDFmCYdckiC8B+ta/OrEvs=', '19f45653d5638e9707cacb0f9de54b118348256458e5cf0bc3059e6916b09d89d5855f86b780f679f8c25dffacb57c01c7e0c8d41a88d33fe6f3261e0204a771QzL+jJqN39Uzh9VDqpKeHeN9ktmhQ9R028kxcYHMocw=', 'dd740841db9cebf2f15cb34533528b502ac63aa1384c4ba4361d98a6415427a494c9728344c3414433ecdc33f6c5d2c146cc673b4d2532e20dd8416b299e2c11fqbWpS6rayM7WOUyQPY782skQAgcFcNtFXo327IU3bU=', 'N', '2023-06-19 08:03:16', 1, '2023-02-16 16:38:30', 1);
INSERT INTO `branch_masters` VALUES (2, '532113c910b7c20e8e1298a0acb0ddc417749b3bb367a934872555a22286411743d23dcac44eea88f67447844abd7f7ee9de6c728040ca46072ceedfbd4dd991+WhHDiWnWU46rVIh9x8/64uJHrNjC8ApYLctQ9WD400=', '5a9949ba266dddf752b69bc1e81c872fd6f22cc679641575a818d7ef32d3e77c9a85eb26a41e8a378727a2d8add736befcfc8ede01f6346648df1d7b265b46fbboRgdMvcxvh2TF6KlxVwKfn2mQ8wpJDAP1FmW1FaCw8=', '043227281f733fe9130acdb1e4164de0556d57f420ca8e69fb55e66ee1c23ec2bf42ab9f83a0cc0fa49c3044f8b571683bf20df7f237cc281cb3989e5254a5eeVyZQOZU7rEyZj5wU+RM4JenTy3yXfyNu4osXRs/1jrY=', '280308780c37a4ad916bea4e8f2bac71026d998f962a14286a8e31d0751ffdae4615926775812b490ef621015579cecda3c5b1b2d4c6d27411a3d2f176d27979GT8tpcfRzjtM38ryKIvM0vJ9xRvG+X2qd02NKQ+U1kKRyQUlE49+jnISuCLAeZ38', '3f9c3e5039bc2a5a308830a5f47493b9080e822908f6925bce308c88920650bea322efaf609bc9f2ef4516186fc3d83fe1abcf8ffdd4807b298a40693219da27CnvlOzX1cN8+73noEa3TotWgP8IkF8OF2PXpXbhMlrE=', '4bab889ec1648649224e650b0d6ad76619f071379152524c93915b836ba562a13ab47a8f9577418d14cbd7ef0f951185b39c43deba82361bdcfb1701652b47c3wR9ArYfbq9lGO7ZNW0PeoqKIOMDQGKMxRIMxOmyfZ3g=', '3fea293eff9c9fabf8817d71263b11220d3cea8b05632f7e9ac5a1c314861c19909a1de15e7d607fc32dacb6353ea9a5ce744eba20059e95d68bd708c6afca99tgYaYBgBgGXooSFcaV8uKW2BEIKObIwMnOoH82JK7iU=', 'dd6092b187316e01892e32a3a9dd4653763db19578081016dcc632477db821c6c889f405be78a276520a174d30665f6d84b846d5bb1e76aa572fc1c2fb2add3d404DkaFrx0Lyz+tK2GPj9eQU4trF9hqCfMSz8IurMrU=', 'N', '2023-06-19 08:03:13', 4, '2023-02-21 17:08:17', 4);
INSERT INTO `branch_masters` VALUES (3, '8afb112fd0df93add27e4bdac6924fec3b3e99c4bbafc4fd675766ec947c8794d1e1ba7cf8a7b96f14a0384524a83e6eb3ff218bb0ebeb846870b4435d19b806xvI2XUuUW7sSVLWdK6Wb/ZRWJDJl95+UqWicVN57lkA=', '2d3f99106d8c41d2df9cecaf17992c4e58b3a9c10c3cb6e70b3df489285e645043b991fb3b0d7074369b142850cdd026ce5ea0940d09f2c726e025dd0b485cc7TnxeErk9NNfCB/WN6vxQyVEIyQgPu1xUNCAN+4g8xAA=', '3bfece42e6b21d98ff53e02898f1845df808bbf82d46a4f5693e67b77ef62b36602ff11ae702709a2cc0cd8196b6b720641cd9836027ca05b0ced034ca137c477+ZpfVCt3M7VbFbfPj7jQ7EiIqyZh5RKR2eZUOXNml4=', '75210e0c5da8b4133fac119caf0a936461690cbb39abc97ff80f60a960c0dcbddf742b9c7b6b6d48fc524de21253ef3c97db81040186204752f3a98a357c4b33xZwAPSAfoa+L7MBOrMXewVZm9ctaKmSx+4yBHG1okIJ05ngFUrvC/AjMhH8POYhI', '08eee7bf866241e7f2b9f4fa068b17933f4c8361bc2874eb12455f5d83f9b8c2f03b0f99a651ff5e5f7562f765a69a319f0bb91fd51ea61232357027c3aa975bVsxFxEVzqGR3uAsReLC1YArCM/uOZ6OdnlK3v2Ts0YU=', 'f1d02ffee4ead0a8a40104380db11a6d45a127034b3eca5d47aea2de4b104ac8151c3ba9771963ef1097843201f4c0fab1089aac78e8633a943eca5ea01e7fe33TVObnv+gI45bnIYIOed6+gRgtWT1b/qB6jXutmTQKY=', 'd7c7618ca31686588fcdad2ab29b08ea068a976e477fb4412b14804cc967cad49b891b68e4710ad7dc79f496052810278ca628994591acb4f3f6094c018008a2q3oY3PUQ5Zldb7QrEDKSIgvUsKcbGC91KQLGo8Bo4cQ=', '2c6f91b791bbfc1a117a822230bd9583af2249b9962f0e514a48a04a45bf5f6c085ab1ec3efea0d76077c866c042ea7dead07ee8cafab94b3fcec4839488ad1a4lo5DNQFpD3+ksKfSdk6cWkdqCvkDB+Uq2xzYFjoRls=', 'N', '2023-06-21 04:29:00', 4, NULL, NULL);
INSERT INTO `branch_masters` VALUES (4, '07eacad3e84ab4d36a4e5bb8c1b0a1b30207174e7fc930bd1534904f3f7ca7c892f3b865990da32aa5a444704f3d5a83b15dc4f749b7751843ae6c578ccd4d49tVZ1TlpSoeJh2wjAkGaXZMbF5jlPe1jel5gRz353E4k=', '5315c60468263332f365ae170786fa86b96ed2748d505c538d84968da18c36b70095ff8f3b1038a3cb24fbc710632f8d2da40ab8ab37b648ba7900142e3b4246cEP1RCTwZvVqaKzVDGLvTst76rMutbT9p9kI8Vdvt20=', '55ae6d9c413de889f4d7258aa49dcafbea7335f0084eba4277943818b4565252450874306320c61c6ee8ca61bfd87c6fc1c6d04d77ba7e68ac0b477552358f0flNfRXDjb7sdeBeSCp6uewQ59R8ladsaihmPR66L8qic=', 'b68b1f1f603f0e4f1febc5c807166a6f147a7fd184efea1c7164ab131e1961a67a8fa3e0128ea1ab86c1c3a2547b482044cfa0935ce5e78070a5ce37eb55a2dcUlUNk4BwFNhP/w6tHobHgU+ha6Df3etOgd7nc0RQen0=', '08bfb5f72cf7d3dec751004a2b5fb34ba802d92fbea463cf18124323ac7e78a530c3a0ad7cce3134834294b3f8c3f45bbba344ec512ac8bf60803f4227512236HNBMZzEVh+E9wVSa/t2ZM8J+nhyrQ2dmkHTFlGVE+SA=', 'cf9b02adcb84f8b25e6c64018588d1a0a39c4c9f3130541dfa03c03d278cf7553b6ffbf2ec9b8fc8cf2408b538ba41c24ab36328634152ff6b29ae5ce1d889e5Ub3+OPy4QNBncJhQhzXsqTtgweTJYWnORN3OhyW1d1o=', '82f25e94a654a133531be2d881cdb904a1aef467066497336027abe9471b8ce75d3f5ca03b5e4d1400b7f8663ea5accfe9acc51bb0c91b261c0038d6baf5b09fwvv/OQxmVhBwfHcjw04cgJozFOXb41WukiTw9pWIbDA=', '1da8d43fa4c7617af20a6d1c14485b48a6864d3e9918f053b2bad1a73d5572d80c656c52e79d6e1967f7cdb8dfa26337136e18775cab7c48e19e89de542969a1fdT93+JdNlEjq8jdNbKTxbLLa+LqZhh6NDmsf6pXBCk=', 'Y', '2023-06-19 08:03:01', 4, '2023-06-19 13:33:01', 4);
INSERT INTO `branch_masters` VALUES (5, 'ac5f5ce918a24a2754aeb0a19efecabf8e1f4c0abc0b98bdfacf874003aa86a99e33b916579fbe9dac6dc48c703314b25e52801b9cc77e2cf5149b1b5a01010dWttflowogMNIhoQQnzZYZi17Ad8TYVcGC0wcGJpZF74=', 'dd89eac3ed4ebcf991cd356fd9fc2511769802f7712d3f9953f7e98e897f5e688aa241ebd1c791a6627c45d7d42a10118c6192c88b60bb29f3e1b1418be6a113ax9Rm6jqhn9CIoX4rgEdtC0DgSgEV3yfCZMER8pm9qM=', '436c6cfd64721c35bc55a3414f783c6b8aa6e970a6c693ab84e94f06693f668ea6296676b7139b5690e1559db7b3080be4cb19a067e5297d6e922ad97f4609a6Qq3apUz5doENUprP7lGrNfH3DcpEcHFLMNGJ08YquaI=', 'fc8262c2898255a648ecd89b04e128f9988b84ce67fac357ee806b0563af07b6fd4be74ff4cc3c8569953cd39261b3d4ba3d000d20413863bd3accbfcad5f90aUotG1xuJ0P3dSSGYZfZHflHqh5cR2QyH0trWZ1YixjQZXul/WC0RuhIp9vLgdUwX', 'f36e573ba03a4137b944a92203a340925257d0c9fde0c0f7acf17fb57d0b25efc80a9ccaec8c9a5aab32236290eba647769bc0d83e9de2107a7e3cd55aa1e4caKWCgCzMKKCSyg2LoMInpg2v0x/FbAJzuuVYg9Aootgo=', 'b497f51441f95f802a034087c8e8a234f097829639c57698338fdf39a565e7f5d2d058b691777108fce88dad3fbacf567085002c1a4e194240185f519231e6dc1V89+21HGM2psjfl0rUS8DVbub55rtCkANcwGY7plOE=', '274ab74da2e6df22f1a0dacba4f93d8887275f8f1a1c6b4bbe55562246498eff8255f43ed4d2cba46c34f2858c6897f2e33312e6ed069eb17d30d2711ef8d756mCsifRXfm5BREWcgmdqAfV+H1noeJgrlwdZyBz8xWck=', 'f24d2a4bf73890dd39ac160a0df8fee3a0995d6a93c458d47b684a4f89d9c334dfe6a149759cdb15e8d5f68b232b791dc5df4491db5cb8ef890ede945950a304jFFFpp+gCs7uZbCe8mcP5yfvPkROO2P7KkceNrB4aG8=', 'Y', '2023-06-20 10:04:25', 4, NULL, NULL);
INSERT INTO `branch_masters` VALUES (6, '7a0713513c3b68a9562e8406600a81c1cbaa4d6bb9964e538ad8f6d6a976a9b6af03e003bccd7bbebdb6808a7e2c7211f8d368005d4eb2274d4ce089d7de2ddfEub2XP2Xw6LPdJFstWjc/gGcoaKA71Z+PO3D+2zdfI0=', 'c41b573befead7906c928c653a5fc0a817a3840bd948cd5d339a5e570f212a4e21a99c888069c850bd300031d8024a1ce5136ae44f614675f3f10d6d4af90572THWdwpfsfA+biZ1moP2fIlGaqcLMAzrlC21ydD/gDBw=', '0b659999ba1c60aacfd406646d4be7dee3fa824b48261bfbea86b50e3b6bf2b0addbaacbc72c5912768a706eec089fd03c061db19755225b45b47b27d81ed409xCpPG7RlGhcG0RqKKgco1Z1wsFurnBOop/mdeOMZwHo=', '13c841f5a21e5486f581a58b1b045c9cc40f5ed183562f9f39c0803911d872da6ad19d8dcb26c485d4713117ddf1378c4c95d1140cf6b9322a1ca3e5f4831d23sE4TFvep4coyqdigVoYnn2JilxOUXzORpwgox0+4HDI=', '315ee288e11ca2190b258ad358b5f84ec90b59c3de19fc5141e30c819f05f16354c2558708c8e2a4a85c3a6d3fbab039ad7e219ba9b55a59e92024b0f33a10f8bYFhOeJ/I/jcnnFURYRSSXdGgLfW8v33yjP5+r0QXas=', '69f42e1f25fcd084124c1ba7562172b97ad283e5173fef7be18876418507b93495d061d5ceed4e00325f20411a7f42a0d1f55c682581d098df725c34533381bcySEDzO/q+IVVeaY2E8CBOCjzZitDT9c+DITSN6oItJU=', 'b4d7cb3844869e8423ac9706a53c00c48e92304aeea61bae5074f404b4c5de12ec7643721f497412252a20b7595cbebd058e7eca2337206894d4ce0a431d22f1IgNQVNtsa+YsqZ6YakCHgvC5fFtmHHduyVNCwLQ9ezw=', 'a7be3e1b3b6d8c7f08ee3889a67184a98e5bdf1c447b040087ec69913a59ec45a966ba258f44218709b9293f617761068a7c3f511e7b7cb19c1e709bc3cb40a4g47tX4siZECKuW7FFL46j2MYNUJ5EfN/MVQiaE0zlLc=', 'Y', '2023-06-21 09:41:19', 4, NULL, NULL);

-- ----------------------------
-- Table structure for city_master
-- ----------------------------
DROP TABLE IF EXISTS `city_master`;
CREATE TABLE `city_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of city_master
-- ----------------------------

-- ----------------------------
-- Table structure for co_applicant_data
-- ----------------------------
DROP TABLE IF EXISTS `co_applicant_data`;
CREATE TABLE `co_applicant_data`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `co_aplicant_gender` enum('M','F','O') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'M=Male,F=Female,O=Others',
  `co_aplicant_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `co_aplicant_relation_to_applicant` enum('F','M','H','W','S','D','U') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'F=Father,M=Mother,H=Husband,W=Wife,S=Son,D=Daughter ,U=Uncle',
  `co_aplicant_type` enum('CA','G','S') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'CA=Co-Applicant,G=Guarantors,S=Survey',
  `verify_statas` enum('P','A','R') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'P' COMMENT 'P = \'Pending\', A = \'Approved\', R = \'Rejected\'',
  `loan_id` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 32 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of co_applicant_data
-- ----------------------------
INSERT INTO `co_applicant_data` VALUES (1, 'M', '', 'F', 'CA', 'P', 11, 'Y', '2023-05-20 03:01:29', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (2, 'M', '', 'F', 'CA', 'A', 12, 'Y', '2023-05-22 18:23:48', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (3, 'M', '', 'F', 'CA', 'P', 13, 'Y', '2023-05-23 18:52:40', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (6, 'M', '', 'F', 'CA', 'P', 15, 'Y', '2023-06-07 23:55:38', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (7, 'M', '', 'F', 'CA', 'P', 16, 'Y', '2023-06-08 01:20:59', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (8, 'M', '', 'F', 'CA', 'P', 17, 'Y', '2023-06-08 17:28:06', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (9, 'M', '', 'F', 'CA', 'P', 18, 'Y', '2023-06-08 18:03:13', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (10, 'M', '', 'F', 'CA', 'P', 19, 'Y', '2023-06-08 18:05:52', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (11, 'M', '', 'F', 'CA', 'P', 19, 'Y', '2023-06-08 18:05:52', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (12, 'M', '', 'F', 'CA', 'P', 20, 'Y', '2023-06-08 18:41:18', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (13, 'M', '', 'F', 'CA', 'P', 21, 'Y', '2023-06-08 20:17:25', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (14, 'M', '', 'F', 'CA', 'P', 23, 'Y', '2023-06-16 20:49:29', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (15, 'M', '', 'F', 'CA', 'P', 33, 'Y', '2023-06-16 21:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (16, 'M', '', 'F', 'CA', 'P', 34, 'Y', '2023-06-17 00:37:05', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (17, 'M', '', 'F', 'CA', 'P', 35, 'Y', '2023-06-17 01:13:03', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (18, 'M', '', 'F', 'CA', 'P', 36, 'Y', '2023-06-17 02:39:32', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (19, 'M', '', 'F', 'CA', 'P', 74, 'Y', '2023-06-20 17:16:00', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (20, 'M', '', 'F', 'CA', 'P', 75, 'Y', '2023-06-20 17:20:44', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (21, 'M', '', 'F', 'CA', 'P', 76, 'Y', '2023-06-20 17:33:42', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (22, 'M', '', 'F', 'CA', 'P', 77, 'Y', '2023-06-20 17:36:46', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (23, 'M', '', 'F', 'CA', 'P', 78, 'Y', '2023-06-21 02:32:36', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (24, 'M', '', 'F', 'CA', 'P', 79, 'Y', '2023-06-21 19:05:02', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (25, 'M', '', 'F', 'CA', 'P', 80, 'Y', '2023-06-22 02:47:11', 18, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (26, 'M', '', 'F', 'CA', 'P', 81, 'Y', '2023-06-22 20:50:32', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (27, 'M', '', 'F', 'CA', 'P', 82, 'Y', '2023-06-23 21:06:36', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (28, 'M', '', 'F', 'CA', 'P', 83, 'Y', '2023-06-23 21:16:06', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (29, 'M', '', 'F', 'CA', 'P', 84, 'Y', '2023-06-23 21:19:16', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (30, 'M', '', 'F', 'CA', 'P', 85, 'Y', '2023-06-23 21:23:33', 4, NULL, NULL);
INSERT INTO `co_applicant_data` VALUES (31, 'M', '', 'F', 'CA', 'P', 86, 'Y', '2023-06-24 03:23:09', 4, NULL, NULL);

-- ----------------------------
-- Table structure for co_applicant_document_verification
-- ----------------------------
DROP TABLE IF EXISTS `co_applicant_document_verification`;
CREATE TABLE `co_applicant_document_verification`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `co_applicant_id` int NULL DEFAULT NULL,
  `sub_tab_id` int NULL DEFAULT NULL,
  `document_id` int NULL DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `response_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `date` datetime NULL DEFAULT current_timestamp,
  `verify_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of co_applicant_document_verification
-- ----------------------------
INSERT INTO `co_applicant_document_verification` VALUES (3, 0, 31, 11, '{\"aadhaarNumber\":\"983003788699\",\"rationCardNumber\":\"\",\"consent\":\"\"}', '{\"requestId\":\"a65d499a-486d-4e82-9281-03e8c0b7c35f\",\"result\":{},\"statusCode\":103}', 'N', 'No records found for the given ID or combination of inputs', '2023-06-26 06:23:54', '4');
INSERT INTO `co_applicant_document_verification` VALUES (4, 0, 31, 11, '{\"aadhaarNumber\":\"983003788699\",\"rationCardNumber\":\"\",\"consent\":\"\"}', '{\"requestId\":\"8e7ff019-8fc4-498b-aa3c-b9170aa4dd8f\",\"result\":{},\"statusCode\":103}', 'N', 'No records found for the given ID or combination of inputs', '2023-06-26 06:25:12', '4');
INSERT INTO `co_applicant_document_verification` VALUES (5, 0, 31, 11, '{\"aadhaarNumber\":\"983003788699\",\"rationCardNumber\":\"\",\"consent\":\"\"}', '{\"requestId\":\"2698d02b-e2d3-4fe5-bfc9-c1fdae7e8297\",\"result\":{},\"statusCode\":103}', 'N', 'No records found for the given ID or combination of inputs', '2023-06-26 06:27:24', '4');
INSERT INTO `co_applicant_document_verification` VALUES (6, 0, 31, 11, '{\"aadhaarNumber\":\"983003788699\",\"rationCardNumber\":\"\",\"consent\":\"\"}', '{\"status\": 504, \"error\":\"Gateway Timed Out\",\"request_id\" : \"b0b2ec38-9281-4609-bbfa-afabc1fc361f\"}', 'N', 'Endpoint Request Timed Out', '2023-06-26 06:28:40', '4');

-- ----------------------------
-- Table structure for co_applicant_field_methods
-- ----------------------------
DROP TABLE IF EXISTS `co_applicant_field_methods`;
CREATE TABLE `co_applicant_field_methods`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `co_applicant_field_id` bigint NOT NULL,
  `function_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `from_field` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `target` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `target_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `result_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of co_applicant_field_methods
-- ----------------------------
INSERT INTO `co_applicant_field_methods` VALUES (21, 13, 'blur', 'SELECT TIMESTAMPDIFF(year, `!co_aplicant_date_of_birth!`, now()) AS age', 'co_aplicant_date_of_birth', 'co_aplicant_age', 'val', NULL, 'N', '2023-07-14 09:55:49', 4, '2023-07-14 10:54:25', 4);
INSERT INTO `co_applicant_field_methods` VALUES (22, 26, 'load', 'SELECT * FROM city_master WHERE is_active = \'Y\'', 'co_aplicant_hghg', 'co_aplicant_hghg', 'val', NULL, 'N', '2023-07-14 10:00:28', 4, '2023-07-14 10:24:50', 4);
INSERT INTO `co_applicant_field_methods` VALUES (23, 26, 'ready', 'SELECT * FROM city_master WHERE is_active = \'Y\'', 'co_aplicant_hghg', 'co_aplicant_hghg', 'val', NULL, 'Y', '2023-07-14 10:24:50', 4, NULL, NULL);
INSERT INTO `co_applicant_field_methods` VALUES (24, 5, 'ready', 'SELECT * FROM city_master WHERE is_active = \'Y\'', 'co_aplicant_type', 'co_aplicant_type', 'html', NULL, 'N', '2023-07-14 10:37:31', 4, '2023-07-14 10:39:37', 4);
INSERT INTO `co_applicant_field_methods` VALUES (25, 16, 'ready', 'SELECT * FROM education_qualification WHERE is_active = \'Y\'', 'co_aplicant_education_qualification', 'co_aplicant_education_qualification', 'html', NULL, 'N', '2023-07-14 10:44:08', 4, '2023-07-14 11:07:28', 4);
INSERT INTO `co_applicant_field_methods` VALUES (26, 16, 'ready', 'SELECT * FROM education_qualification WHERE is_active = \'Y\'', 'co_aplicant_education_qualification', 'co_aplicant_education_qualification', 'html', NULL, 'N', '2023-07-14 10:52:58', 4, '2023-07-14 11:07:28', 4);
INSERT INTO `co_applicant_field_methods` VALUES (27, 16, 'ready', 'SELECT * FROM education_qualification WHERE is_active = \'Y\'', 'co_aplicant_education_qualification', 'co_aplicant_education_qualification', 'html', 'result', 'N', '2023-07-14 10:54:09', 4, '2023-07-14 11:07:28', 4);
INSERT INTO `co_applicant_field_methods` VALUES (28, 13, 'blur', 'SELECT TIMESTAMPDIFF(year, `!co_aplicant_date_of_birth!`, now()) AS age', 'co_aplicant_date_of_birth', 'co_aplicant_age', 'val', 'row', 'Y', '2023-07-14 10:54:25', 4, NULL, NULL);
INSERT INTO `co_applicant_field_methods` VALUES (29, 16, 'ready', 'SELECT * FROM education_qualification WHERE is_active = \'Y\'', 'co_aplicant_education_qualification', 'co_aplicant_education_qualification', 'html', 'result', 'Y', '2023-07-14 11:07:28', 4, NULL, NULL);
INSERT INTO `co_applicant_field_methods` VALUES (30, 15, 'ready', 'SELECT * FROM marital_status_master WHERE is_active = \'Y\'', 'co_aplicant_marital_status', 'co_aplicant_marital_status', 'html', 'result', 'Y', '2023-07-14 12:24:30', 4, NULL, NULL);

-- ----------------------------
-- Table structure for co_applicant_master
-- ----------------------------
DROP TABLE IF EXISTS `co_applicant_master`;
CREATE TABLE `co_applicant_master`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `co_applicant_panel_id` int NOT NULL,
  `field_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `field_name_slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `field_type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `master_or_value` enum('M','V') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'M=comming from master\r\nV=Added value',
  `master` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_required` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Y=Yes\r\nN=No',
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Y=Yes N=No',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of co_applicant_master
-- ----------------------------
INSERT INTO `co_applicant_master` VALUES (5, 3, '9e02d7d9ac77e264990a7de0d7bde184d906608cd6692605d6b34cd47331f2451f842513a79403e67ddd9a53ee17e32c8baa568ad291c8a58c43515965b5083agCg9QE91BuOkDcRwYw4OX7JasLMXOR+ecwb8u5DhJqE=', '8a2bf137f07198a65ad1fd2ac34f9a940650a842e3b5bc54d21982a8b1a48cd3bc0f8ce3204b7d66f3b74ef092a90c4affd993a288e315257965115566cbb1e574cSAMF3kasCMnmfQpjOIdJ9pRxO4lvg60+0W+nY+HJsJb7AJZjyadgrKTIn6B49', 'bd0c5a49af5316cec563a62b04783f0f1c53e4a11bd09df9835277d05fff890332c82ea68f9b527539b5a2a6ba6e1f72b12d445d76c59d18b0dcde097505a85eDR39CBqmtT7p/AM3XcVFJbWRhrNm76EekgelO9vb7yI=', 'V', NULL, 'Y', 'Y', '2023-04-12 18:05:24', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (6, 3, '68d654cae7439c71cae37df966dafc01e05fce81353cf3b18bbc5cf43f6063e0c5c4091e9ad8a7e21c1dd16d6b6e2250258acdcc680f6c41fd0678cb5de5ca3ekIQwBvFvOPlmmYItTks/BSS57p5a+ZvfWhD46QR3Mo8RLWjYvU1oA4dROc33axI7', 'bf371e2f16b903e0af0df8d46d968178b9608f90268fce3d94d556154acdd821ca35128767dc2706647cebac88522f659d311d14e67b9e4307aa28df4dab839cyoo28fOUYnhnTekL/WaVww/X6jwbWw/00/SseLX+RLon3pBu3s+8keXAbFhBabId+WFWotH3vOBDpjATMwf5Ng==', 'bc2c96b1a1607fbe148fb111d49d855ad7e5af128471d0cd2310558519afee4fb055782d833fa3f56f771401fce303352b58e7008a80b18f90e2dd5640f1085dFo3cG/KZJRK/w+zrWLuKAabeQX9p2p0/QJAeVuYiQOs=', 'V', NULL, 'Y', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (10, 3, 'cc9535b84aab5bb9193a1df997f977d790ff992208eaa46cc389019bccae587cbbd337989962bb8211cb971fcd50e1c6fae49bf291370365ff5f793ed1b0fcb8TjjtEKnFRt7IqJR4qZ50wZ0uU5YT4GM7E9y2zfnSYgk=', '45006375aaca4936440e172bd6c6b40e62dc0d81751ecd3e3eecf25ef58a79d7266f3c051fb5a000331bb0ddccd398d6a2ef0572a672d0bdfecf4431b25591edfjwjhWEec6q3D04ReejEBbzoWAW+fxVmKbeFQ1SwAiDDZEkEZ5Yyb8vk5kifOnTP', '5526fc63da631c607cf847d0fa0a849f56d113a83ed38f433018c93f03b3695c4a8b479b48ccd7edc30947adba161fcc9c19c44ea9ad6afe0e69fca996bec4datw3slxs/I0DXFGtlhBY4bKWFwhZ8pWOuUsrK/8dn4x4=', NULL, NULL, 'Y', 'Y', '2023-04-12 18:14:29', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (11, 3, '892d6a0b9eded023c6d3354984e2bfb60f69571f679a35edbf763018ba81507315d6e0c2cf5c34eeab468cb407ac838285f87c214ef8b223dbcd11f864df0699GCqeW0MKwvXNqM/WtGu522lKnKsBxTP1sUdwqXU19No=', '3e673ea8c1b51769e0fcee44c249e9ea42b4a4701e453456eb4a5d8936c6ec0f84dd69566649dd94ceef1f59932254826bac1538b46dfcdbed74e35c85ef4cbfIHdP6YF7jBHXrBMxLi95woStCel3X43FChrrfLRTDtgKaBRz+1npOHXj3X7GAKup', '5d6276e127938d3bb478b08e998399f8bfe04fc36f61e43f58cb8b12f2ebdbbd36d95b95d99bbd1dd16ddc21aa05bb7a210bd96dc0ae092161dffdc119882060krILCLnMtHUHclPJIUZsaFJ0xYZEXiYyBN4q/A2c290=', 'M', '605c881760382254b3adc15a18a52cd2d19f01c658cac138230f75470b303741235b738063acab7b2e94fa7996d01e1fb37915477bbb5b7a78b023e1ba754569luiaRcGwC2VMuEgNLO+QDG0aKaSrjFbICDGZQVfPNQQ=', 'N', 'N', '2023-04-12 20:52:42', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (12, 3, '4ac58638c107498b8e2673e7a1562a21524ce9dadab53948ace84ff328bc823d394467f9c680ff433b9a311d52cf49d1c3220a925d94f8d0bebceadb5864e244dDNyo3oHs9X3UWRuMiUP4BDsuPJCKlK4e0X5xRKOueM=', 'edf0792170c4f312a34fa93e0b100d807bb77021ce04eb7d089154f8f7fa40a7aa3c0fcb57a54fd22e456a39f5e68a3b234dadde381c176d0f8d4dc26189e0fep8fbpOadZQroDYSxTTB2gSNkq4anFt1djDcsfrcvEppEGxo8nIHQqhPu/gmzpF6/', '64edf15de0b5510e25e968af7a587b7e8283008a8b92ea36e68b5ae33f0bc7d8a1a0c234aa0a5c54437dc65351c3f9286160d8a1b683b0b313e0ddaf6fd4991d0/nLD9uP5kvGvVKhwLmgZDWBUBoASlBkGrjpV5UkhsA=', 'V', NULL, 'Y', 'Y', '2023-04-13 11:40:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (13, 3, '2680fbf27e34f2664f371baede1f27b5a6bf2182413a8df0e360ddfad6c7cecdb75f0c596a6c3feef579b368ad3a73218e44f164601342c811904966dc56e2c0OUCprn76DWOhsIlNSqJzt4DIKaX5+caMEloZz2GC1jQ=', 'd68ca9acfa4a5d9fe68392422b0663dd122db34ec46b67636ea8361d64ae34286043dbdb1d78ec191829198d25a1319aa7e41439019359c1f61a2113b54f134dEzOIupjFSQwaoUFPWN2tdZ7/ExKpgCEhFstbh9fIJieyGGOMksbQXCUSZs9KrsfF', '60b53465e60d23a90d4aa182e70832ebe5817b5f5730fdf91483d909bd569ef0f50a1215e548d722c74af4246441e4870d32f049ac9d6f97d44bc6dadd70eaa4oTN7bC6WzUE2Y8OeGcKkpmSRWKM5J6EfQVxLP+cPRpk=', NULL, NULL, 'Y', 'Y', '2023-04-13 17:20:01', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (14, 3, '30aaef4887df6a6beb462293ea39e0e8009a92d3df3e9a5a69af5e6fdaa8d86c6e82958562e7caa378c07c8bb99bb6cfab21c3bc1b647c7bd6b3034974a05816qmB6jiB4hpYCcw1tzAuGZyuCyNJQ14pR+QyvG5iMOd8=', '057a88505d5a4c89116fea66c639fb1ae246d7b728983e1a52800c40fcef86b0498c4c97d4262914417108694eb3a82ac04ead1c714d093201adc721eb889208UMcEaalN7Pm7JOVPY1lm4lHnM92LJopewL4Yvm64tmY=', 'f106fb9c716d1350431baabe75d495d0e977d7ab39cd4214ad3f9debbcfe2c56f9d7829d19be41c6bbda4e412236fed62f1c56a7871df6154d1954b7ddd27e61LVO4pRdznx9uHKBuZNOVOGj9EAY/TVe0UR9C8gdPECg=', NULL, NULL, 'N', 'Y', '2023-04-13 17:20:52', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (15, 3, '501e3201fcf5279d6dd061f468ca2238545fa564e6081cd88327a288ccac81697180c7c508fdb89bad6cea92455dc94f420716f297043392e4c7eff0a374d16fb7UiDTdyw4FYzk6jhEui9DnU5JrBK+YnJD2FVKMG+UY=', '2516dd3c5f278c262c8e346872c6bef99f7b235835bca1201800a68dd158158086b387e13a6719b2a4924b90a127a41c3a09a21941c0774f2efbf467b7089e3eHzbe0fnNyjD0MpKpN7D0sZ1BVTR3EC+mQA0535cuOMNyAa2HNQicbDitjtXsEWtr', '41c938efe5b37d142ecc6d0cc0ecced72f3c327c2b36fc458e7766f7834f0e839bd2251d07e7fd0fe946db7a63ea7fb22456a4d27c5fab21e17e32ea304ce280MGenUWExQYU8K+xfM3r6OZjuPC+Ufrh3SlxM2jsuRgU=', 'V', NULL, 'Y', 'Y', '2023-04-13 17:22:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (16, 3, '4e0844f5b38e2b60eeaa0222129085cc2a6b27c9f711be0a085505867b74e0860148d238078cffa43f8b08a172f12d122c2ca3f08d30de6b51b38f24c04bf247CxYI+SDNVZxiWf/xjZss3/+dvhCbH1K6E5rZPb3O+/BQl1nih8Xq7Sm/LU/3ljv2', '32b23cd02ca6dc3877e298da7bfd12784df73d6ef09788c6eff8032712642109ce064a3e14facac6cdac68fdf437e2f1f6d4c33ccad57667b1d6e4a6e08abaf9aXrqgNK8fQHHLXqT/2knVP+Xlr2jyhE7JEBG0kBgT8TWcHHk9IFl2ypVqaYMAT2ClIYF42fwzKMU46pNMdhrpw==', '0e02c1118023cb304dca4d23b04a38ac8831be11d605d2589b34440778eeba342b59cfc63015b2c6e06a69ea19564a64ea3b54e0bfc9bfe6e8505be89be94856ft/i2iJZdP6fD8oborvV1jEvH+XPZw4igJ4HYmpnj+0=', 'V', NULL, 'Y', 'Y', '2023-04-13 17:48:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (17, 3, 'd8357757e91ade0f478b2274d67bc498f1872505221fe96d141ba3564130e32c7ea3b78f3fcbe9e00c843b8358a93529c9191c7d08a22d6d93cacb5326bea56dcvgcZ05gJdLAw5++Vkh1yl6xa/tl/iKME7TWLmEFBTU=', 'b9c92c86d39c47ea56595697c581b2ca4608eb99231c6b42200971aa50f8c619940974625434662f16e02315625ca7d2c35759e617dbf2de96ceafd035383940L0MvGXhVtISYHczHzaog1MEA7mvzk7zIcp7/dpBcbj2C2jOyoBUkqDkXK2VPm05d', '8d403cef8b3edca7cac45270e45f4057e22f6616564d8e78ab5193611c3ab5b5b1c1d9a2d63c516a06fcb928f688a123248e296eeeab6e8e611acd58c98fbabaiyrzKq+AOtPi1AWP6gBDgvpO/rjfodDw/SgNBH/gWtQ=', NULL, NULL, 'Y', 'Y', '2023-04-13 18:09:30', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (18, 3, '6da7380b57db1321e7977430a163ab4ef07ea9982b26d4d5fcc41655d1027d3439e2201032bfc4c8c994fa2fb26c1dd697b560ea1867c1d8ff9dd63f48369954aRQnGtAhR+3fD1OsSTitnmTAcSUF/xqy6sUpaT5m5G0=', '9df341a65a68a6a74bc28f779e0cda6133df744bbab8b08d9ec21cd9497286ceff03e6cc8832449267ec936b20cddba384540e3473f9a114ddb9db27697dccb0DMhVgxRvMR00q/D2OnhIANSPNPEWmqkR0BGUYH44ctfDNfAPbqYOl5dcXjzxNAln', '29c1782cb94f7bdb6cdc6b3c8ab8a1b6456e48b52d269d894aa3ef95787764fa4787d83928e50b80eb6b3fd7c87d49b8e5013e4c38fd7c867cf77a755043a320ebCxHaPtJHsrfTXSRWZr7CeopejEBDZalPM8hDZKPQw=', NULL, NULL, 'N', 'Y', '2023-04-13 18:10:20', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (19, 3, 'c87b918db19a203b70db7f6d8fde61aed2576268bdf486cb81717682f3e29d404769ce8eaee891da9fe9b7850dfef1eae062c4a9e9327d3b1bcbc5a489255639AL0UGh64f79cj7p+GZ5nsCh+4j7jxZ+cfOR241W/xUg=', '38040f7e4041e9b39f64dd3cf6663e7efc91041204f0647a2110651cb4652bb656a297897daec43ff9ae5a3a3a84b7aa5db5171c6bd5ef6d320b591e76163287S3W0tBLgYwqaPm+EDM2Db1ZVeVYeBMkCbfvenYsKfF0DWRlXipBP3WIgvzqCRS98', '542d4b21fdbc87fda4798ec241b1cf34ad35e40c22ee5d6f3027e7b580dae5884a599ce6d26dc9abab1fb1996b2d22cdcad5f7d5d0ec87f03dacd5d2cd3199269wYfucDZBhPzZrHSLA3Yd+doShlb7+BHgokUhrfAiUM=', 'V', NULL, 'Y', 'Y', '2023-04-13 18:11:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (20, 3, '762bada1f8ecb29d14d35ece7f1274d07b03c1a1ed7043a0c86cc7093e226f8bbb94a6920cfcd832591cb1da8e3fbb70d30043ae8aad4db85b752433f2395301Fim5aFn9lf9VMf5ACQ8qFhlHm3EN0q2dZ2mQW8zCUrY=', 'f4e18a49c10fb027bb3333a9535bd4ca0cdeb4cd16b6c9bcad490cc12c6a5a010a8efce1c401c32891a328e6357591b7c661dd80f72b1f1d4ad697ed58a4bbc3eOxS5iv4oJ+0S1wW1x80z6ahFbsNIc2Lynx4WnHo55OJNDuOZ8Xb+plTHp0IP6ZQ', '6ed01e39ebf4d717ed236e23f334166298e80805035dd418e5a371e2fbc7126e572ce3c08f3eb2d961a4a863a0081c5797d5bd70ffb6d95d338a98a75fb8720dirH137SXZQK+jhaaxi7Sw0XUV5p9j5EW2KBTNizFtiY=', NULL, NULL, 'Y', 'Y', '2023-04-13 18:12:06', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (21, 3, 'c409700f09c33af0b42a767cd573c7b6935ae8c207b8aef8d09fdb8abaf1aad8be97b5b0a78cb6615209f95f33a0347007a6e822b962e88255b5fdae6b50e1dac4pc+1dL2X/y/TCr87nWQrILoG4AAiIK5hkv6ZjCL2s=', '8f39bc4ced431d876f3dbd15d30dfc0853c534c964fcbf4ec0883bfd35cf54ac7db78ddeed89f500e81660a9356d0519689476f7179a6d2b36b1f135c00e6a60LlAGAvJrHPKy7GvN3ggWX3GFStV5oCQFH1tWkSNSdXJcLt/T4RZikELLNFKZmNMT', 'a8d540173ef10a057a41c10948315b818827ff3792e8a64823e3856294d29e0343ebf608cc2288a7313647c987742f4a32a0e9f954c0138de2e28eb694ce2381U5j9b4filEO3BqFgq3KF8RvnEK8gE1okM07a8WBgi0A=', NULL, NULL, 'N', 'Y', '2023-04-13 18:12:28', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (22, 4, 'd2800f637e5a5457d9ee3c2294c4a1ebf97a4680c9d565da378976c7ac200bf573741b6d9f9a5c4b4b4ebf93c25d40b4ba41faefb85dc6561e5a72eaa60515b8S7IfShhsJLABHOxpPBBhzWNbKaxo0yLsndkzxAi8ftU=', '981ac8109f80c1809befb39567b02d0862dac405dc35266bcbc1ee73ea56f0d51bff8dd0ef9367fd44c8328462a8241af8e530a9f0cdff309e1b29a1bcc57badqvUvGlF0PsjUEwjXN0Hk/urc8OU4+u1RglYicTAvDf7iXRzdLcxOd+JfSa/NbHyo', '585456fdf061bccfd0aceac8f9d9981fb3731ec66b8a757271c79570cf2d04e405b7ca82f0ed284ca6ec5dcf3a097778de033488b26cdfdcfd0abbbc283e1671ssYBKTOdyakLP+WETnftedpmZOxIcZ+LyhUcljHyTf8=', NULL, NULL, 'Y', 'Y', '2023-04-14 20:21:55', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (23, 4, '766a2e13d1734c742e4df263cddcf893e1d4721b2354dbeed22da9f61758dbcb873eb8f01ba1b7c570cd700678ef433a8706fcabb67f8331de83a678e7b45038v3LHstOVDUo8WEiHBlKeD7Ti53tB6px+WrdPfGTLfHA=', '4437669c2a67222175ede7cc042577f9d90780d6be52399d57171865bbf990debc4edf2ec56e5d6c4a4bb7102bb73a15acfc1ab97fc74eda397b03afe5490047se7bi0nYNwRKfYZoyTuqQ1jrc01O74pPSHrxAJonXeUlJShObLPd7Z3u8lM8/Z6Q', '150aebe35884658491b1ae27ee00156d2e0110958723b4a0d4214b782cafb97abb72ceb324c2f6dae702729382ee47af9bfe078d2da7e3415f712353a5a1dda2aW2OdxP/VuYhjf4LVxdquaJPEWhAMIBpLxbkueVrDwQ=', NULL, NULL, 'N', 'Y', '2023-04-16 19:06:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (24, 5, '1b9657a2b85ca158256daf21f9b14508789f7daaf31334c93899dd458d3d1864f08825b814ce6426e3b6acda31d5e29f3e6505eed5010a9c6ab60a68aeab73adRPSVT5LY33KgXuQew2fKCZkYnfx/tnCw6yLLU3ejV70=', 'f83843b4c0d31b2c19b821d525588843e8c71011ef107a7c4bd28c9abdcccc1f793574abd23095e2e5982edbcb7008d558868d1a5756082e7234f620341fd1a18PMEfNXQZolZsSWkMr6aYJQT0okjPxxLQV8+3yfvff7rOxm4iHm16G3Wn2M8gSqg', '5b4c9a3568372ce96555f832a407f8f72c62ab20d69f078d528f84ff5f63f688cb49c38808acddce2a2936a87ec609e27d4bd9a04eee2332b0f5a0688729d071Hri6y790V+U9nbyN+MgG5fxKaOdNXR2vrd4uCrTZqis=', NULL, NULL, 'Y', 'Y', '2023-04-16 19:07:05', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (25, 5, '4413548b46ee6a6358d27c7efaf0c9ad1de8cb81057b3ff7ce9191abd86a0efd5244aaff244b4e80282add9478d61c85f8e6720d67bed319a19aba8d52cf62e00ZnOv5pgRjSMu/7qknH38lIL4JaSIaPFM0gnmplGKcE=', '6865669012abfbb0cb6d79a8d5bf7e25696c146d32adcf528b978c5ed8d065dca85e288d2a9d261b7275375f1c4a1552c36d1d6afa31b17ce9ab4cc1f89941f7c+uGTmrkOVSB7x8V7WRfNBYcAQkiSZ5RByti1XIqsfkwJdiiTN6Z0+Sz6uBxLUc4', 'bb233266516d5b2d425fd11a9de5047479b91744fa835cc6df93f4f8bb39eeb87babe9b9d6cb1d2a34d07b2ae7d82962fecdc009ddd918741ce0dbeaaa20af793qH4OWy2ZJ3Ch47GA12Pc/Gd+OBxj3u/+R4SHv1umTs=', NULL, NULL, 'Y', 'Y', '2023-04-16 19:07:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (26, 4, 'fe1988496de3f2b50dd713f4fe7f71e72f013066704e010ab25a6011859367c94121c3734f195d3be59f8d5aed9cd8e648e047948c4e4741ebde23480d1fe6829/16Emf6gi6amyi0kTNz9Z+BeTzhYBBQKaMGDNEpXqw=', 'ef29dbf1fa7304aba1ba05b35dfbc366061b2ade4bb3fa8263e7a5600ec8b95087dc64f80de6cd79d0b8861b359431cd1eb771439850281fe43eae5ca9591581ZCMIFUwVHgFU/CHPLNSqMDiJi+QzXlYIPVJiZV7OYS9rOS9cS81qXuKb+l2DCDBL', 'cfe8295e8e4e8ad3aa00bf8af9373d90e825acb95656ed9cbb4603534d809c6b5c7ca23bbd510e4af4ca09b952f1ab2c133837fb9c564aea1aaf0a1558433b1ew67TCVBUTlfVqiRMKN81P0FX3uB9Ye5iwWDoVudu1hY=', NULL, NULL, 'N', 'Y', '2023-05-03 20:01:16', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (27, 3, 'a4b8deb653113113269faed187a289e487413401da2fbcb35728d7372a24ff9dba5ed54d6d11f68df6bf4af8ca6d60d1cd3189635d2d2507c2cca9476f81ae7eDL6zxgxSECfomL8y/pqaF5cU2rq/SD/TooB6rthzkaA=', '02763b07b2e19b80f38f22e4f88713cb4635c3d9ecec90830f9f902d3501029d567be8a30f683bb571506644bab113a3876de2e495b6325f497b6a9a4747e60cFemDdHRcHpBRThtpl3YRxRI1xRegoOU2GCDCVGkJtwA=', '50e101d9b0e3aebe3dee9cf36ba3cb6135c043f08429daac184d5e2d9d4cc619c889ad01d0bff687f8ce9f9c894ed55b87b77c518768564b9404ee0ee0b8df38p1IRC+Hj39QVXTocRQ3FaZQ8uBY0ldm+D6NkT0mXn5g=', NULL, NULL, 'Y', 'N', '2023-05-08 13:14:47', 4, NULL, NULL);
INSERT INTO `co_applicant_master` VALUES (28, 3, '1c30a3ef510355d46120df67c8cc054db591c83ad48f0d43466e8e5b89aabc2ba1433c11e95ba8b80220592314b1169f9fa7b449ddc65d23987b2dddff88a457axCeiTEl3m26tmAcnUBH78X5GQ7gkAnZ0JL6/iRGf9A=', '4b5e24b98b79e2bb183d1469036db24d344de9abf714f90cca1ce3e22861876322ce0ab46b6e1dba938cedbc34d89063d33fe448a71bda0de582a135a6229c405ZBL8n36Cjf3FyAR3dNoooNYXwjbvwj8yJ5K5DWwntQ=', '01a88abb471e797acbb02d2fd14bd7313329d6db2b9bfe8cb8c137b9800e8e95a58aeae7bb058fbf906dac908c335e0d5ecba21c217faaea65071c9b6fd9399fKLGvnarcY/oGQFH4yh3PGDO4kFQ1cgTc53aWJ1wJ2LI=', NULL, NULL, 'Y', 'N', '2023-05-08 13:16:24', 4, NULL, NULL);

-- ----------------------------
-- Table structure for co_applicant_master_select_value
-- ----------------------------
DROP TABLE IF EXISTS `co_applicant_master_select_value`;
CREATE TABLE `co_applicant_master_select_value`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `co_applicant_master_id` bigint NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `display_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 56 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of co_applicant_master_select_value
-- ----------------------------
INSERT INTO `co_applicant_master_select_value` VALUES (7, 5, 'e8e3eacb6ee5037d501b6dc2959f2430842ba42bb349ee8b3801037d033d75608fbe5b88be544ad83498424c0993bb112680f6a4a56ad0c172b29ef9378f02c1oUMpJdgEjWLF80SQQf/UCcMebky/dq0wZxvQcLzyrMY=', 'fdeddade974fb849598aad15ace6d2dc0cfbeac807de4226959de349bdaa589bab9c2417bfc18ef77665d1cce316ee53d05dce760e1502e361643a66a3749d39SBwyqY6l8h+ikgfTAXZsWzKUjirMWcv8AvOKLn/0xd4=', 'Y', '2023-04-12 18:05:24', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (8, 5, 'e1eda5924ab13f84ac86e3eafd63f935585ee841aa15c953b506b62e49cc8cebb9e22d179af9ee0905a60687c6fc4e9190a243dc8949321de2c889feb527bc7e2rsIdpMKGowcg/6VmvdoSTeDH0DHSnyl6hNWOh3OxZQ=', 'd305f058846207c525bfb0a53a12fd12c311bdcb8415d2607ebaf040207f53981a3dcfee361e46e6e888a5212dcc527cdc1cd54e505e8f311aa1258248fd1f75+fGP5n+8mg3y4GPY8c3Gy8FWIR/ZTzq5ZEpasXca57k=', 'Y', '2023-04-12 18:05:24', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (9, 5, 'bd27c0cfe8e4fcd3223c50de69916b345caadcf639ed4068ed5068da7eac608522c3f008b40f635fae8dad7948ab627f002311d8052a09f16c2db7c58ec295favpobqDYHEPYn8qHbuwKqT+QUdIHDw9mSOwVg1tDQRCU=', '3b0e537af61c636d443dd33fd193552b4bff4c538b9ed5142633f49adb9c36a7eaf4ef4f8c6e51ef6fcc781ffb988e5c5a4110d3d451125ff9b444cbe3a3d50car6X4nRZgtaNaev6UhNW4pm4V+DMeFjuVoT/9LLxuX4=', 'Y', '2023-04-12 18:05:24', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (10, 6, '2391191c19d2032f2bcf876d38b8eb6950a5aaf0ec963de41e8b588bac1761d53fb8ea74bf3076d9719a9472a0a92a88b60190b8001d65ee90210cc3d38dd225YzXHTbcPESKiFpbC1jCxNL83SNao9wK8zxQWo5Wxt/M=', '48c56c7e5dece2f314e40a18af1c45560c466b2dce761c91b3fa3c53478901fa622fcc16d9f1981e725ae3d0480d1da1260a9f80f23dd0434c80c0377b381ce4psEB9jYATP2spHIkP+H3E44J8Mbn7wjth4XFKZSmRn8=', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (11, 6, '0a740c2e7caaa847c96f6496813371c36172b5a111b14b464151366054dcf563107a5cf8ac3bbdc836b695378b4e88a297f1939d5a4a564352db97f44acf6522soWWP7M9Miw/TknBgJMZXdYQeB7uhyumH5eMb87zlxw=', '3eab082d409aea4a4df9a66abdc4b598462392a73b25848ff16a9a244a8fcf0202aa9eaa7c9f61d090b7915ff71e9d174293173e6eb7835124256940b2a2b317G7iE+BOVUarlFC0OGydJBQBAJplDwvWm1+ykwU6mPAQ=', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (12, 6, '07268cd268dec130e155c58d2f941dee8dce0d41f93a1b21ab7a1f818f616deaaeb0f7628a786daa2bfba68aadbf806f04b5adb7767a52e1fbe0f8a8f24f9074HkLo7AjxR7TxV6GFbeyJVwHNfNhLo2hwAezsyJff+xY=', 'a2c0271e12e5b298aebd96ae731607342df1fb7f093910be5bee653c3178b76b3cde51d9ba7785146c02b6b2c8dd42bcbccfac78640f8ba039dc6e198cb75699KNTmk0o5qrtqCzcBai1+ZeHdfPKh7cCXydYvfagT1KQ=', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (13, 6, '7be261e5bad98d184280eb160d60dbed2aaa421a26decb7696264ae4cf9a47b81d271e33dad2384158ffbd62c627738e751cce2bb5d454784a029005695140fepwuQIoC+JSbIAZs+zns1LVtWKW5BDKgM8UV4y7eLKfo=', 'a5d1963d62e62c2a5000fd7038bc4a317ff796c24f3d676cade26fe1af3586686c1e76a143a57aaaaf9e3980ba87fc23879ec618c2773058ca6590c1b6e994e0vaT8t60JnAHG3cH3hApwEHTNogkrcTuTZMjxVkUjsK8=', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (14, 6, '0c6b3e4e56dc95108cffa263ee0860a3ad865341374b3c64861e65550e7388791b9ae32f96cce954db7df3e8f6c31982b8365b9e75bbe6122143ce5a38114526MuKIt3sNOgpsP7Y8R+oTy5uBJOaRFxLfVDl/GQ/ACag=', '87f55de566a78126d67e7353fd0bf524455c264ccba2b91aefdcdd9adfb36597201a6bddbd53648861a36847ff8c9c9d5f3606290ff46706f252e0136dbcf4c6Ie0Ltyfhfehjy5ROV7FS5IaL6tS8CWDuncgHyrUge80=', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (15, 6, '876af9069610eed6bf9a9c1d8e86d44688338219c5f8920b7a4fcf88864aeff1e235a0a20355bd0bb1b882c7bfcbb4f6ecf548d521f218c9860ef197bc7845615w7+gGGyk5XszaK44cQoPRyfAMVaKMpBQnN0AUuCEkw=', 'ab40867d77c2e4d8d7152e080cb533ba77681cad60aaa912214bae8dac0569e5c52bcb3d6b054cdac638aaf7c8731bd0da6a0d32535ed5cbf83c37f733e58b6dqOKou5IdyZ3h/VeW1pJ9fkX4Es/3daL/2nWRCbDxZO8=', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (16, 6, 'de50aa1e3477ebbb08e7ef9491e752a69df2286c92480bac7edabc37807a72f25b7f3fd09ed2e2a956457f27186b5bddfec8def21636a1eac612079616d69fb4725r0mpn3S0zU7k++fc7iQ6e6096VrDEL2BZ/7rvtZA=', '6368d45ba4db51e0db493e1a594f89f31539f086fd67f2c65c745d0f79be1aa842a7976668c388e95b29572da9a9e17b250ed3e175cd63a9b64d8aff9e0f50665qcBfPyR5ykBvvn7/BtrtBHjifcEAB8vkv0K2FGU9/g=', 'Y', '2023-04-12 18:09:25', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (17, 12, '33b1d600dd092fbd3be29d8b5027902ac0cfcee00bf3cdcc3bf256509c8f3847dfe0a258e05f617bca9f5bfed2779426b23fe7631a56f3f767628b61f48732e3OQULyZzEPSozITT1M2V1tR5Ww5HGqLZeyBk54cLUmRc=', '1b45017d9799291c073acf8f2d5d185151eba8f8fe7b4c173a331701f98c1002237a6cb144e6d637d3fb696792cdc7dd265bd0a13f4de9bbc6c2b34215ca3492xiKnBF4/4yXmQiDOtVcm+07vvyxiIlCH8zW3eGUBPE8=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (18, 12, '1f5c1bdd72a0852c24dd66852dfc7bb468eb8603dbddc8c4d6c2aa3a773517b1325b1d85243c994cf97a5b1de5e5a9b1cad9a90e0dbe66e9b212c587a08a96c6LtlqZLWwEWdaDGKWBUvOx6g+A31LRQoDJxMLO/NH6W4=', 'bbaceeab5c24c81a59a1d9735426c4be58979278a516dc1c1b9c70b684f147ae9758797a07c0c868c84845769e441bf6c9b2f0beb6f0b55c41adc063d9815eb5OQbToLh89QvV1rXY5hSpvBI8h88J9LvVmV+2fxkpbFA=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (19, 12, '80db31ffbd15ebbf28b94a63fe44870c5aa46e3eb0aac60e20eaf371e92a1124c3ae92d51559a29fe859cdfb3e40f0662692beb3c0f07349dd770ed4c14f6d0deQEnFWyxW8jqVUL6lBy7TQGWwkN6iGiPnhY5OdsQO5w=', '14a5ce019fd6ae3c47f382dfd76d53e759097b46bf8f0d4975e9c9e331d95793d971447761ae1c3399ba874c95707fb7362be4fb6ffe6d4224120763eb0a7f58whAJb77PvgEOhiH7l+hgh/u3g8+Zka1NlaOFJ/GxsWo=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (24, 12, '74e3ac3808035ab65238b0778f4b072e9efd0233e7bc57a83f943c450393741d855da41de50bf54344d99a5bd6ecb2ef39b438bb730d551f363ae936ad66eefds8dciuwgMF9h3BP1gyb5mI/kMOJcNn+jR4ufwYhM+UQ=', 'ac8253bff004079947be35bafbc769796ce2db4e6288c1da389defd953ff53b7fa56cda3735b25b56937a5152af0c2e353e9e19122a6d568b31ebbf44566c3f8dblNhBHJwzfKM3gZr8phZPwVS580m3skNcrYk3g/MeA=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (25, 12, '137baab8d550d3d4db1525df82450599fcd7fb361f1c6d067b5233fb4b4c1f7bdbdef56f5d79d8a5fe1e88750e9b7af7dcf3a4cf1cb46db48e7466f61648545316mK/dFe00Ih6iytmNEgb3bsWqqqxnZ9LUaxvz7/zzU=', '9aae136ae574c95a17b973692a883cf307d2a6a67d2d5cf95afbd8af42a520e587e715006a6c13adba3ef7dfa29d6678a87d74c9fbaa4b594a438a22a3548535g+TEutJ6i9ZTtf+Bxehf2iRVqJfxXvxY4Qr36pTs2xY=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (26, 12, 'c390a41d5eb45ef3684acbe4be0524754e9b5771aab6b90741939129e28263b5e1e458db659758a604348032865068f808008b39061b198cadc56a7c168885704Npw6RCASiqrOdzixEDzN4Dc4N2iZ1vWTni3XchboxU=', '7ea9c4ca49c194f8de5ddfa03537eee41617a8f204156a4a79f5724ef2bdf78127fef11d25a18dcd33eb9182f98e5bfad52691346a61d9f76e639ea305ac840fvM5YZorQavodNzdISCwfXm6aagNyaDx6ph1IAZJ8vXE=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (27, 12, '3a58c785e2a0bacb54cc50852c9dbab952be74080f0b95cab588b620704d0deca17c58b1a364cca03faa1cdb214fc4f0d87e73ba4003832088aed907ea9d9fd3s4zoo6IKejGIGtGd+uiS32MHXj+YiOB5UBMUm5Ybvls=', '1fc9ae8b42e667842958ea310a439b2219717beac05ca242cc72f5e44d75cb340138603faef1227f6b6a968637e26d409158230beadb02c7bd50b0bf0216a790RAPlSCiwtBkJN59gAXNkG5ANyfSiJgSjgrHXGh/9iTE=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (28, 12, '769cadce846d92e6de62f747538412cd5e5afd8a0e79d105db831ad846e92a417b95ad40290fe2e83908bbd8a7a0a18bbb5b99196538370b0d13e1e8a87e3746j434hRxliomCYB0SfukPxmr1SyTYfIx5c0OABs+P0j4=', '10eb7c91cd8227c6027fb3dcb8066d6cfa0c211144dac7595c7a87feb715c600b398056d43ca42f4e48f4e7ac513afee10a90a0df79b73dfe06476d69ddc66998AboLT7FIB/u2V3WXHgZxNgPNrQIyb3HPAzAgo2P8Cc=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (29, 12, 'b64f42e1286008382a832cb540539a42839a72b913011171def77fbaf17390031339b93847a75c1a2cc07c23dab8a6e5bae0ff5551640e51bc9eda9e57c11d30BNW8HjUlYkw3bIZsRY6c4IlGCSN5rGz01MGc6h45TJY=', '895dba23983a3a6c9b4ce2c36af66c2e331c9904ba5f30409961ba9e70c681c1880f405b6910bd5ac26092c0055dadf290a8f70ccdfe738379b5ecbd334b441dWjvgTxM6Fp0G8vq3L0fiXzf5hpGEHutdtn5UCNcY7fY=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (30, 12, 'cb2785a0e9faeaf3d6d93a83005f445f3246da5f67fb858ef72e4b7dfd272aa8d97ee2614937c622882d3a2400625e097b2d79fcde37530fa90591dd2c8ee1c0QgVjFMkClELxzYp0395x0h3Pgtjf7HCxazdZWuBIGso=', 'c93a245a14c581185e48f4542afb9e0b23ce08f963c9efc3df07c86e0fdae2c099f8d70d9625c6d0165ca45d6c730ac441e8f083f86e298c01b9f09799cebc92jhWSy6n0OAHldX9nyE3J7I943MkuAps5WYovwkioCOI=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (31, 12, 'eee47cd12f89baea060d7d88e70adf1953a1cc753f38aaa20a458db943142f3f3dd7a657072a6497f67e6183ce83f39d5ca56f5cb00c07b143c0d028b453c238RLGeEljWAPTMB0iXEVJPsVaz2ONwTEiZpiDGFTffGHE=', '8619a94e8156c72111fbb188fe30cd3518b47a026adae732400f7bf8fcb2537a841bee454285cd1ab5e2f9edc659e470246968fdef25693762af80a0c6eecf26Rfck95KVmYFsCZqfBpe6x+lEj0UUmCjZJT4JaHZuSzw=', 'N', '2023-04-13 11:40:34', 4, '2023-04-13 11:40:34', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (32, 12, 'bb3da5397276f2af29a0a7d569b2cc50feeb3728c4bc8fa66f262a6c343ebd9dc59a14bdbd21359efc5216e10eb48ebb684a8637ae5aed61639e0be44b97b1caEQsp+OqD0lj1yhes9oYZLlhR7a5a+tO5zKapGpEvVMw=', 'ca44e083c7a2918251d927dbae52039cd5d6b342a95ff9444eb5906e23e02a0042cddae8d1aa9cb52416c94c624ae0cf1cebc9dae8372c5c29c1d6f180243081Zyx7yZKm522OuVZzJH0WJf8d6Uifizc8pvhe2RNr7Pc=', 'Y', '2023-04-13 11:40:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (33, 12, '010b5bf5dedfa587ff1aed654cf5905588572b814b8043a3c125ef92a28407d41f93acbd22c7cd98699a7d9c4c60f3442088dc9540ab6c21e88ca742c38d0486cfHZ2+pB8ybwEa4SM8leNSQpCYj0o8X7D7mQSD4kMQw=', 'fd02770509515ef77354581b5e0053d340c5baa50deb7e58496b56c2e2bd8e44f929a8caacab018692d2c0c5ffda70e563a566161f23f6b215574e67798be77btAPr3kZsebtIa0/EOERd7n7JQI6recXdMMSik/IMnf4=', 'Y', '2023-04-13 11:40:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (34, 12, 'fe9980f4b440d186a0da11e615c4e7aaab72a81c8de1690de9fa7ac68b7e5fa76f4685c0f0db736af191b88cd18f897c91bdca6f6e6bb762f28d3caaa0078ec4VZYdVo6ZE6JQa3mE6L11GEq2ypFD+F4ryZq65Nok56E=', '0cdd9c4478502344cf0b7c60cece347fc30be8d6e0d054fdc1c772392accf7ffadba44f3732b228d2692530ac1ec82925304cfe8c828deef42f85d2123a07a62si+NtLIIBE/cZNdM/PVzztLKFM4bD+k/DPR6WY7n2+I=', 'Y', '2023-04-13 11:40:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (35, 15, 'e5d70668bd6c2cfb5f6b4becb20a8d98a3e7dc8297e33b8c9a54d77bd700873cbf00fd87fd33a5200870a2910e59dc484e1697d18a6269460ed05d0fe69b8e3an4xAXtsqDVNIkQW1FvkOUqnf7TB50mORxJbvbU+Zphw=', 'f8e48ed1773220c98d230c8cb448d7d77f3fc3ccde1f8e88ce25b5ecd2a0415f2e0e1dbace9cc79e2362aaa32a4649c40d7507a548c0bf65f9334ea752e34398EQBaMF8r+TKFGy8mG9OwWS0uM+FE3Dt2g7veOq2Opm0=', 'Y', '2023-04-13 17:22:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (36, 15, '6ad78b08fa1030bb3e1c251a37b885c655fda28540e8abdbfd5cd0549a36e18174f9a72d15b29419048e76a569be3869de93498c9b49313d423d9eb82f5e6e54A+u3zO+QUQ4HhCZBOzmy6r257zlcqkg++BgFcZgpBVs=', '5955c8cd7f6114fd9de6f9bad67002782f2a5a95de77245ff14c5f670e0b7f04b72d94ffbf1f3dffb9452a2ef40f82e57166bb90f23fe8e2bad0a34b54528cbbycOnAewROwVbWVpPdea+HaY6qZNCejHrwyCB2xmhjY0=', 'Y', '2023-04-13 17:22:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (37, 15, '73fde33d7d5cab99f9944d5b2e572c1a9ffe50e27bdee4f37e4f23d71b5fa654917c3344dd07a642b91cbc1566f7b2936b123f9d5e079720c33631344e3ab010v61b1hubMoTKgyb4+CFMhPdnRvLwpFpr13Nyug/7Fxk=', '73838eb399db0a5fa96e7cb9af0006820669f87a96861693bb3a04247ff73bd0edcfda5eba58132cb30a0470a3927888eb61364d688612ef7917c415c722bf0biGLbK35Mrc3dHs07/MW35CpxZG+UHIg0FmHruZRA2X4=', 'Y', '2023-04-13 17:22:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (38, 15, '929092f44935bf0c7ad80b74fd99150e0a16a366050982f24e1c14cec2d938ecfce61179d9c18e68d326b662da24835afa294a6828a0bae86cb9c037707f4de8BTcx1P974iiZ+yloNpWTy263F93L8AxQwwoYvP8uEgM=', '09ff1b78a62648d215d929a2e794f99042f7193f4f702e56fb427bdf6c6ec4a3a4811ccefc83bfd481761c68567b7384359a4189d7a008a91e612add35973a00s2AdJ9LcNRp1xzROIet6LYFVMIVMfyvIg+JpaJHlplw=', 'Y', '2023-04-13 17:22:34', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (39, 16, 'c547ae29d3e4e9d55c460775dcc190f9bab700e0e448cf65f804837ef587af57001f3b705f96000dccc01d20309436abc3c3811cc88ebdd60b5fe0ba0e7a5a3bPMzmPPeQBVjQ17KiFol0McEnNrkADDRSlcUYIxLN9GU=', '7cd6f8b04e05ce72ba45b43bdb261bc8a7baa65fb811aa1858f54a99d5acb609ff11193e664bffb29821cd0a612e47018938cc1c3b734863dca001be83f7165esNKNLHGB5g18LwxTTBVf7XwmOkDqjzhWTSFNunsi0SA=', 'N', '2023-04-13 12:18:35', 4, '2023-04-13 12:18:35', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (40, 16, '5fa4ec1d72d708c06c12d5cf9c2d707d3361ab05f433791bc1f68b44e2a24ab6d7020e7796e6908ed7634c0b11491852995c1b1b7df60258350725f225361a831XsHRaKlLzp5sq3eMIbPIXDqhixSOkqwQeA/cBw2W1k=', '16b8241b07719781836e117f4e3cfff5c01217e464d07663e2349ab58b9447c056e98854ff046979547102bc87937a8a16a62444c9b266c351a3886df99738c67+AN4d+uDlDnw8qVshLfIPOPneoeoT2BxWzlWOykiDc=', 'N', '2023-04-13 12:18:35', 4, '2023-04-13 12:18:35', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (41, 16, '16b5698de21b92e686bc94538d9fd0aff105c17272c9267ddf16b25111b38588b20ac08417d9f8d1d7045e7a1d4ac2811dc063b5751abf600587447ebae78a1cq0ZM4kb00k1kU6FkmVIWTKm1P05gLSSJ/HqcPlGqf8M=', 'f0957ad409ef7630d1c8e28bb20fc633ff1817d7a94e9af954e4280ef6328a3cab9311032c49e1a67189ad74e27e5831bff90c204c67f89a33a7df13457bd3a3XVsiKHfRpR833FT7il8F41g7BSgODheysDCj9jGz/fA=', 'N', '2023-04-13 12:18:35', 4, '2023-04-13 12:18:35', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (42, 16, '6bfc5d25236ae3b029238c8ba26542b455939457c97338407d1edccfcb360961bc9d42957cbdcca5c055616351ca017b34a6a2c8d1101a8cef3228337934ad72S/1i5WktOEtUPcrv3UAEStdtS+SL+2CQTUPcqqGrIBM=', 'f3c71a72f7359e3a9ee7e2f82a5acc692cc85ae0d279f3a5f2da979ec7b7a7cc0d2948c1bd8d9963e363abae3d3d013dfde904aaa574b16b1af429a0cb358023xIBsAKj+fXhYXkZWqAeD2rghD6xRGRQd3DCmYfSKx/4=', 'N', '2023-04-13 12:18:35', 4, '2023-04-13 12:18:35', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (43, 16, '2b6c2759128da218c9775d4773a883304441e0a516fd6eff7e335818e55ea1f520cbb908aec5b96669828c56cd411bf899f5a320b7ff16003358fafc383aebe839bPLcwJPw/rd/TBO4BavaT1G75Av07maG1rFzoOidM=', '46975f398b7170d9f194fb63e0416a8c52ab49380bbd0b229767ce57a3d18d76fcb0331a0777712fc3d3ca66b5c8972f88bb1ff5e9b5f5ab6324feb9ed8c9a77uUZMfgWTW0Jg8MQGBndVWuNr6KbHznUZiAnGfgAq8dE=', 'N', '2023-04-13 12:18:35', 4, '2023-04-13 12:18:35', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (44, 16, '501dc3bb218c0b17afec752b7264b16f9afe37d1f20b11bf172721bc94aba20cfc6f765f9289b56ee787b4640f66f84679827cf4d2105006ac3193752dbb5da0dqY1FbOfuxut/GWDG4VF2qu7gViMG78AlHPvngqnoXE=', '1fe2b99d57409642013f9d704b176392358ef63cc1b0468ec9d4d9ef12813e051172860cf4dfcb647acc1f796d4bd7647ff1b465b710a2dd3629aacd8d1f10e3AHd3mvZN+VFKQfivt47lxoFryMV/akJFdS3VDSdPhfU=', 'N', '2023-04-13 12:18:35', 4, '2023-04-13 12:18:35', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (45, 16, 'de944b1c50095ecf5f99bf72f126538842388dd5dfbcf6d133662df984b96f96782a78a8d4f14b6254b736e9ae876e6cedef64a7d551a2e754492d90355c7bd6/PloDnQkpM/gBtyMH0LFnSQoOQ+s+1UW/rWgoUQSi+E=', '38d50c9af8a8bb56b485d2418bb85612c0a34ef283179e27f8921442e1c700de686565012ad79409322c9365a055a20a4d889fb8c5390d5cb1ddd37ef1a593far5Pd2GbQvnMqxfitd3SKRw3mvHJnhotiEIaxnz7jTHA=', 'N', '2023-04-13 12:18:35', 4, '2023-04-13 12:18:35', 4);
INSERT INTO `co_applicant_master_select_value` VALUES (46, 16, 'ca99071242bafe0af6b3cac9cae113e428c964c77b6da678f16f4d2718c4e7699516b84ae2eb89978be78118151213e952a0e7d8ee08530159715e4e379fc344OYTHFD3r2EyLxVoJK2RCdB2YXshCq3S+h4Oq9INFc9c=', '66cf72b46ce58f598657f395360d45f861651be3c4b95e971bde66a682f37ebbee35dbd89f1d918ee2c9b38a263681018680bc1918f72ed37cd1f2bb2439d01fjGHSmvFVJyEgLdLMIlgwTvSIxgrLev6UY0x93qNDPl8=', 'Y', '2023-04-13 17:48:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (47, 16, '4c8aed4924f2093518dcf858af84e701eb70e87011f88470f3d00606c9eb0d78de044152f9735cf250e76cb5f87ccc916ae83cd7e740547ad96dd2fe90b7e1a3Yz9me6zt2ZZcWoxaqUJu7x14jgoDgOImpHYujJxaHVc=', 'e9352915ceb6e3c35992ac2c2fb035351324f32fd69961ed4ad1def63c617c90c3fef38a59058391d00a5a2cd42a79cf41f0dc8568bd38ecadc839309d4420421T8wzvMRg+Jr8k/crgoaq+giJAptF2Ug3m76UafbgJQ=', 'Y', '2023-04-13 17:48:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (48, 16, 'e400dc329c95b911cdef55b8aa75d7bbc156d95a500196cd5b41b9e2f869aed7b921af68a42ed29e8bd4a9d1e1b0ac7d53bdb65dd4083c175e8b7a886b349478JQdis3uIq3p3r7MH1Mu8KRbg7LQtNKCg7h7FkoFZD2Y=', '58038f780dff0303bdf8bde42929befaec0a1e88b2fc4d11364b1d80bfa92dad25b26d8644ed004b6cf12b0175796651934f4a92959b6f8240cdfd4ae11746fcjEmun/MoNmm5Qm6a7eq/oEjTGi1aHtTCNFAI2+uyios=', 'Y', '2023-04-13 17:48:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (49, 16, '9a45a2095441f38a89953de12f4a51c49e49b2eb8f0e9de9a2b66f725cfdfca839c52acf3f39bb293d6a5883f9bbd30f02972e70654773ed973abaa02627053bLwmwWHgAE45DSH8QzKPZ4zVsasjATo5aracQPxboxRw=', '574b5a4a5b5b69d24217b5ae863434d56bfe90ff0365016a12d407797feae2fdb9fd1433291fb31b54e579ca63066d60b7647b540a655d64c011f0a330e3df6600SXuVsEcAbTwp1yTE0LpR7bgIe+lHUB1I/vKf1hw+M=', 'Y', '2023-04-13 17:48:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (50, 16, '8797b23532dad08283aeeb30434546d04644016e2356fff46f52ba9e9e4499d34a92076028c636639a039399f483fa5962c5450d5c756ae40fe6f8030edf1071yWTizcUh1D0Hs5UH+62W6cuI9GUxaVuWj3mtfr32mxM=', 'b2d2d863a772fd35ef659402fe76d7c0e78388760665537ce6f68be818882f4fc1658878743ac2afab470d85a98c5554fed8457ab8ba8f0c481cc3fb044fdcc6tJXJRMGt1XWU8y5R8qBwwFAjfaXUVwKpbQ6nsy9rvks=', 'Y', '2023-04-13 17:48:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (51, 19, '71f6721c8469c7b9e2296e41ff74dd46b46f1771b1ec2d867fb82991c480aa472b9edfa8e3b1daa6a63bfb8d60ea73accade94e7950329364868bf48587f81e0unY3tMUwHtuoHXd8qaGdYmbGxBZwYluR3TQCE0hHlls=', 'd2c2afd5a703f90cec5826706d981c214ffc29e17f693d783dc56fe05562b3b456c709cd6d50c135c18014bbb4877d1f7350894cc5b352e8c11be5e29387e59fniEoTeRFXzgSiKlDQ2GQ0WyJtjes4FYRxHNU+J56so4=', 'Y', '2023-04-13 18:11:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (52, 19, 'b1c61a57d77d2b224e59c0d350d8af68e603610b045c19e4c9a83ca80aae17c4bdecff9c15a3e12161c221e3b57149f34aaae0039b441d1f43db6a524f3493b6ob2moaswZe2l3Q47DR4owRqHhTk6JZMtWIZdgYff6ww=', '9dc46e7ae3773a040b5c33bacfe37e7dad7c391de22adecab9c103c57ff5b3efc22afa053896896ff2d95950e996d8706fab77355671025eaaaf788459a5f80fzxLhtrXcnsTMcNBmMZsiF4eff00BTc8gBXAGr5rHP+U=', 'Y', '2023-04-13 18:11:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (53, 19, '98ac1f1643016e8f7e9155a7c3f0a55de9d96c3594a0b199b3d9db1f05a88a9e7636a678f32476e2e2a79a90ee345704321c6fdfce4fb01acc62283f1247fb1ewDB46lrCH1fsbLC2twdJ091ebpsaJd2mTcNrHhVc16Y=', '8dfff021849694e0b4b2fc9e2f169d4dec2ab64253f3337243fd54f72d34a1e96840d94b246fb21b69b082f7ab615d2c2f231bf66cf50685b2f5846ced2f1326NJVGSnVarsdVsgGbrzpZlzHDYYyx4wqBIqGngigf0jI=', 'Y', '2023-04-13 18:11:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (54, 19, 'af5bfe7083ab7ee813e89ca86f5aa9dfec56aa09ef86569b4fe2f47fe3042a73bb89bfa122b9105f42021bfaf6eac3dd24d8a1519720b997a0895df8b16d14e2g6fecZ2BrijYwy7SvJhYDK2we42tILXRRBkWz9uoV2U=', '8adf0c45c7a95f324121f3ec5d0952d9d77bb209bdb3c4bfbd46d4cd9a2420f4de1450a6634e77335daa33baad3f33048b22cd7375063e91b9af5a297643ef45r2Za9s88XRxgOioOy4wX/I+wKL61aB7yVnz+v1UoRtc=', 'Y', '2023-04-13 18:11:35', 4, NULL, NULL);
INSERT INTO `co_applicant_master_select_value` VALUES (55, 19, '94969e97134342ad10c7d22a08de7bf5bd41e9d7f35e4e7f505121504ff2d65502563f0b133a806b2a39a0d1a89d15c4149afa8d5f77893b526407c82ab397fdDTovorwcIv4y02XUWG93/L7IZE+1Gt8qQfu+ne+obZ0=', 'acc6af7b2b78ccb161d8e8088c9c4b237fe2122dba54fd538b85a81b6314615cc7068ffcc1781577bfe1e68302e4f10eed07650ba0f76428f9f6089e8c7fa63axSr9itMCfQ88M0SX3YvnQohDqn5CIYmyXihaLXnHceI=', 'Y', '2023-04-13 18:11:35', 4, NULL, NULL);

-- ----------------------------
-- Table structure for co_applicant_panel_master
-- ----------------------------
DROP TABLE IF EXISTS `co_applicant_panel_master`;
CREATE TABLE `co_applicant_panel_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `co_applicant_panel_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_type` enum('D','L') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'D=Deposit, L=Loan',
  `product_id` bigint NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of co_applicant_panel_master
-- ----------------------------
INSERT INTO `co_applicant_panel_master` VALUES (3, '7b0762a9b2e3286551fee1c18832da685fedc42ff7ca36895e0f7abc102aed591b8677b5e421b18ea0fa7f490870882485d670941d2ba8b3f5b396b128fed2d4ptS73G9d9JlNKO/54uAeQo6xirYCSkpOdzqleh5ZW9M=', 'L', 5, 'Y', '2023-07-04 11:37:17', 4, '2023-07-04 11:37:17', 4);
INSERT INTO `co_applicant_panel_master` VALUES (4, 'ee2b2a42bd86915a233d4e2feba04ae8d334422d2bfd159140b160939d743fe75a8244dc10e998a8a65ca00bc901f107733bb66b3f4f4f88ef9956c2dce1f04fkLv2Oq8G7FKwkYEQMiLTLRc3iytWpqvD2lhqgZXkIN8=', 'L', 5, 'Y', '2023-06-29 13:00:34', 4, '2023-06-29 13:00:34', 4);
INSERT INTO `co_applicant_panel_master` VALUES (5, 'd6b5c2f9c28a3822c7d1980bb995875897162d0e776422e14894d801d81eea32992cd4aa211a242024d8d2e7ca53bd59ef6fa8e853a78ac3a56e9f3e26c5dd05I9HBvsbmM84KsWDu+osDSVnmrAuNtDiPDPkqKVY8gNciRZ7p4gyH4ME3o8qcadk2', 'L', 5, 'Y', '2023-06-29 13:00:13', 4, '2023-06-29 13:00:13', 4);
INSERT INTO `co_applicant_panel_master` VALUES (6, '4e3137c66dac814ed2c77459985717c203d6a5559a390f9adcca9b788f8d0ab7ef823b5f461e12edab696f2ade830a2d733f74d994ea2198ceae8388fb61ad94h5J2h0BfeFT9KOjkAMgS1IaPR5Zog4DHAe7ZWw7JeZ8=', NULL, NULL, 'N', '2023-06-29 13:01:26', 4, NULL, NULL);

-- ----------------------------
-- Table structure for collateral_master
-- ----------------------------
DROP TABLE IF EXISTS `collateral_master`;
CREATE TABLE `collateral_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `assets_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_name_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `master` int NULL DEFAULT NULL,
  `is_required` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of collateral_master
-- ----------------------------
INSERT INTO `collateral_master` VALUES (1, 'Movable Assets', '25d030fefb5cfd545682447443a844864876db29780de4db182e146d77bf5163563114b06d010c53a647a428d722b85fae86cc73c3e1d1dc488ec4da26705271OlCikFONmV6f4e+3ylxhtgvpRDtBHnRxz5kee9IqVIw=', '258e90461d2f5cbb17318a60bcf6b1fa5e13b2fa4932958b5624dce2a5eb9efac6a88c2be98a8630f4f237500946ba14b60b983edead706c8fbb036d4d583153rwRIcI4Ck2oNVBxFIeVz9ZYh+gCJDj4cxoLhd7bDg7s=', 'f0ecc548a7d92762f37b1d578323e83c3e04d7c8f28db19cf9a138c62543c25e1e856940d4554cc4c92e3b5bdb8f74cd4c771ea8e56806a89c56452adbfe4965IzPUFqED2SpD7igkLEWnDj6SP55Hf8CGsPiYJvJZXXo=', NULL, 'Y', '2023-04-10 14:33:07', 4, '2023-04-12 12:34:41', 4, 'Y');
INSERT INTO `collateral_master` VALUES (2, 'Movable Assets', '215b6f5279c6c043153f5b038a8314f01b662fbd8288a8d45e748aeed80f6dc75b82a9f6fc3133bf200a778d56bb10e5579d2e044f8597908c281efde9e7492080BCrlPVsIzy6l9lBVTfX2AgLVgbsuYWrl99JDo3j8k=', '7c4c12108379e5a13e5f9a3e9a4d6f8f6ef82fd4e922868f9651255198a34768310f0ef38acf3767867d3290ee3cba84ed574b4b84e75feac5ba66e698e264977LBqlzs9F15FwuZ3YsHWDSgHZe8KyZMakbWOE86OSb9i8x2RWkhCr36Q8IrkyOhh', 'f526715d973203d833736fc5bd8e359c3cbf20c8d38aaae8b583a4a238442224a3e4414eebdd32fc5298bb0441e8b0cda7525fffe94cb792418d81b446d9b35dSk5Jpj1ZaCAFXucw3rDe8u4q03iUnLJdPjUOPZyg6co=', NULL, 'Y', '2023-04-10 14:33:22', 4, '2023-04-12 12:34:37', 4, 'Y');
INSERT INTO `collateral_master` VALUES (3, 'Immovable Assets', 'dd50ad0ef19bd9280900101d04f93ed3a41766dd8cc40726ba180de6004539d621f94abc1010a3630953c301918e7b1432bb138fcdd8d9d3a9b179625b4027a29YSI4pwbTz4+tSDKOkXd2aVukJuPTPq5UjoxzESYbw4=', '4b0d633dd75bc6b44986c1af15ddc0856e54242697b90ba69c1b0fe15e89364734604ea453eaa79e2cbb5e84b4e4d43a755b330f9d6af7ecc5724ac20617eaebFxw46ErwWHGThSNwvg4gz8op9hlTaSNaTSfZcI3/JGcCgcTGDOP92fd4Dg2TOZDj', 'cfbf9f9cb7b6a01ad05cf92c11757f3d2e889bf9cf8e933a89658bd3d1aa2dbb2f6a2e97c93afe5bab1a602ac3b9edcbf1c1cd3fa9f97efb29f62cdd8e3027e2SUp2RPBQmvhBHJLb/PPni96mES69cCCStuL/f0mC/c4=', NULL, 'Y', '2023-04-10 14:34:09', 4, '2023-04-12 12:34:35', 4, 'Y');
INSERT INTO `collateral_master` VALUES (4, 'Immovable Assets', '35491d91f262a10ec5af6efa96a65608d03b20afe4377f83f77b9ccfe43c0b1f990469ce30a7c3249bcc22e5934a36ddf09102e7dc2c7fb1b4c4ef3ef62f9643dySO5DMjlZInsHbS5P8baTd/UMqsRxYy76tqRsUXB4c=', 'e3c6113398e093d900c97ec2460b0770c7a640975b67bb4d89fc618fbb7d41d60334893dfd2018383bbbdcdece625feb8661fef4707998c314f52be23f9dfd65DqQDmSLW7xRhswDbOysXtdzaL2E7WvPZ5Mk4fh1w/KRIYJn/Y1Fxp6MfTw9LSzYJ', '68138c55536a83f1fd691c2c621de51ded72ea3ff5358a16550726e276063d7c1265e9a6e8ad834499811cd0b4a086d107cd9d4bf4b9cd15237c782c2c373b6dVOp2zpS3Sc59Z2zuzAWuKxJw2DtRvN7sY7DX+JsYgog=', NULL, 'Y', '2023-04-10 16:42:59', 4, '2023-04-12 12:34:31', 4, 'Y');
INSERT INTO `collateral_master` VALUES (7, 'Movable Assets', 'f937ad8764e4f8aa81ae8270a375b65de72990bbb32d92299d4f3a9d6eeec22ba31e929c0d92e579f953e3ad9acbcf163ee41ff0cee34f13ec233b2968526bc5ayA/L0hpA3j4d8zBTcXsNSj6d+8VAxOdtseO9rKS2ss=', '83addce870c89da6ea5f6a0291f663f3ee619b8ba38ecb6e2cdf1f624dddf2cd36523c0c5894c70b7ac4a3f3c387f854bc68d6b3a93efbb72bd3326feb781ae4ufXw3IP1ofZHTpTPfl33TwUi1/gQTPvJP8Rsi8cIcnCOElX9WFvfG68JzDlCy+sq', 'f096d10a3f2af80a76cd0831467892b2780a8a7c033909bbcdd727262c8684f7b8ed2762f99818875ac11c57d08726ca2d08dba0b1969ec25dcd3a0da0b1bc07pT6b9jcgH51t0ygfaeoe/VK/1RKPmiEslH86sSlvaRw=', 0, 'Y', '2023-04-16 13:43:57', 4, '2023-04-16 08:13:57', NULL, 'Y');

-- ----------------------------
-- Table structure for condition_operators
-- ----------------------------
DROP TABLE IF EXISTS `condition_operators`;
CREATE TABLE `condition_operators`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `operator` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of condition_operators
-- ----------------------------
INSERT INTO `condition_operators` VALUES (1, '==', 'Y', '2023-07-27 17:01:16', 4, NULL, NULL);
INSERT INTO `condition_operators` VALUES (2, '!=', 'Y', '2023-07-27 17:01:23', 4, NULL, NULL);
INSERT INTO `condition_operators` VALUES (3, '>=', 'Y', '2023-07-27 17:01:28', 4, NULL, NULL);
INSERT INTO `condition_operators` VALUES (4, '<=', 'Y', '2023-07-27 17:01:36', 4, NULL, NULL);
INSERT INTO `condition_operators` VALUES (5, '<', 'Y', '2023-07-27 17:01:41', 4, NULL, NULL);
INSERT INTO `condition_operators` VALUES (6, '>', 'Y', '2023-07-27 17:01:48', 4, NULL, NULL);

-- ----------------------------
-- Table structure for current_account_master
-- ----------------------------
DROP TABLE IF EXISTS `current_account_master`;
CREATE TABLE `current_account_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_master_id` int NULL DEFAULT NULL,
  `business_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `business_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `business_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `business_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `business_pan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of current_account_master
-- ----------------------------
INSERT INTO `current_account_master` VALUES (1, 1000000008, 'c80d0373ebe8ad8123ec3ad1b975762be0f7890b55d997e6a09229cec31258d6320e7e46d7e68a07cc69294cf428715e8746b0cd584378f8d4541880ef936e77YWDo5mcZi76PQV17iswMy5Pmgf46k5VZj0GV3S6+uCY=', '812f0ac63fd2563c274678b1c0bef1e387b89912fcb0711d952676ce22bb4081ee6a35c56db0f9094a120c31642d4c6419c495bdd20f2ce2c9381f4e58116d3eNL0zNC4dxNxoQohx7UrFQxN2yk4PPBZNy/PgzUSgPko=', '63a97b1ec2e708ccf958a75d512837548d8baf7b3fedf7d24ba257a399187e9025c71d482ea2e3590d3036dfd378b7f70264ffbef84e63dd2ddd3112897e4cc7DAOXVtrcmy9z+aDHkt7EMlXGQ8ghhbHYu7TsK51zDSc=', '6a7f62445ef6883253f19ee776e59df860ff7afe47acd80445d4374e23a105218776329a1a478d67523cdadb7f4a8c2a132a4a66e54b886cc6a44ab4864b11f33g0EYQoOfbki/2whyAZPMcLISd44UMD++quouUlwANw=', '84cd48bd453a2dde839147f9b21e54799f953b4a2ccdbce0af1f54169121a9da413e84b3a5f6562fe15aca496e6e8b58e6e9eff37ffbf2760f14195af678202fVy/IM6OejhBM5kAs3fuefauFf0Tl8G7az0ZfZUchfKw=', 'Y', '2023-05-07 12:26:02', 4);

-- ----------------------------
-- Table structure for customer_document_verification
-- ----------------------------
DROP TABLE IF EXISTS `customer_document_verification`;
CREATE TABLE `customer_document_verification`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `sub_tab_id` int NULL DEFAULT NULL,
  `document_id` int NULL DEFAULT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `response_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `date` datetime NULL DEFAULT current_timestamp,
  `verify_by` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_document_verification
-- ----------------------------
INSERT INTO `customer_document_verification` VALUES (1, 2, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"8c38a766-f95d-4547-9f6c-0cd68fa107d1\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'Y', 'Approved', '2023-06-27 04:07:26', '4');
INSERT INTO `customer_document_verification` VALUES (2, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"f4e01d2b-2026-457a-8342-a5c29f271558\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 04:09:06', '4');
INSERT INTO `customer_document_verification` VALUES (3, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"13315fac-bb6e-4bcb-a372-ded0ace56b1d\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 10:06:22', '4');
INSERT INTO `customer_document_verification` VALUES (4, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"4be2d61d-d497-42ed-87f3-447bfc97d88f\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 10:12:16', '4');
INSERT INTO `customer_document_verification` VALUES (5, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"df4dd175-6e12-4d17-8f49-2686ab7f7ed4\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 12:20:18', '4');
INSERT INTO `customer_document_verification` VALUES (6, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"9aadf005-43c6-45c8-863d-f27c85affbe6\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 12:26:51', '4');
INSERT INTO `customer_document_verification` VALUES (7, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"c684c4ed-f729-4528-97c5-509eb506030e\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 12:52:53', '4');
INSERT INTO `customer_document_verification` VALUES (8, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"88cbd878-3e8b-49cb-b1c1-bfa6ac1ccb5d\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 12:53:27', '4');
INSERT INTO `customer_document_verification` VALUES (9, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"bb60ef68-a75a-4fba-aa3e-dad1ea493fc0\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 13:04:07', '4');
INSERT INTO `customer_document_verification` VALUES (10, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"20b1cde3-4417-4b86-93e5-01959da7cc12\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 13:06:21', '4');
INSERT INTO `customer_document_verification` VALUES (11, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"122a2083-53b1-461d-ab2b-99746bd3bf54\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 13:07:41', '4');
INSERT INTO `customer_document_verification` VALUES (12, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"244e45bb-a5c7-4445-863d-1186392b36f7\",\"result\":{\"pan\":\"CDPPB0022F\",\"name\":\"Suhrid Sarkar || suhrid.developer@gmail.com  BASAK\",\"firstName\":\"Suhrid Sarkar || suhrid.developer@gmail.com\",\"middleName\":\"\",\"lastName\":\"BASAK\",\"gender\":\"male\",\"dob\":\"1997-03-14\",\"address\":{\"buildingName\":\"2 NO SHALBAGAN ROAD,\",\"locality\":\"DURGAPUR,\",\"streetName\":\"BENACHITY,\",\"pinCode\":\"713313\",\"city\":\"BURDWAN,\",\"state\":\"WEST BENGAL,\",\"country\":\"INDIA\"},\"aadhaarLinked\":null,\"aadhaarMatch\":null,\"authorizedSignatory\":{},\"profileMatch\":[]},\"statusCode\":101}', 'N', 'This document already exists.', '2023-06-27 13:27:58', '4');
INSERT INTO `customer_document_verification` VALUES (13, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"8b182478-c3a5-4c4a-9eea-be24bccc72fc\",\"status\":402,\"error\":\"Insufficient Credits\"}', 'N', 'Insufficient Credits', '2023-06-27 14:35:47', '4');
INSERT INTO `customer_document_verification` VALUES (14, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"256fb2d9-1f8d-4940-9c57-44bf002c16d6\",\"status\":402,\"error\":\"Insufficient Credits\"}', 'N', 'Insufficient Credits', '2023-06-27 14:36:01', '4');
INSERT INTO `customer_document_verification` VALUES (15, 3, 24, 12, '{\"pan\":\"CDPPB0022F\",\"lite\":\"\",\"consent\":\"\"}', '{\"requestId\":\"ad70dab4-8324-49a0-b315-d01a751f83a5\",\"status\":402,\"error\":\"Insufficient Credits\"}', 'N', 'Insufficient Credits', '2023-06-27 14:39:01', '4');
INSERT INTO `customer_document_verification` VALUES (16, 3, 28, 15, '{\"dlNo\":\"AP40720150001826\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"requestId\":\"b6e72ebe-0f86-428e-baea-7d7bc9c58244\",\"status\":400,\"error\":\"Bad Request\"}', 'N', 'Bad Request', '2023-07-21 03:11:56', '4');
INSERT INTO `customer_document_verification` VALUES (17, 3, 28, 15, '{\"dlNo\":\"AP40720150001826\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"requestId\":\"6abf9080-72c1-4138-a8d6-d3193bdfe06e\",\"status\":400,\"error\":\"Bad Request\"}', 'N', 'Bad Request', '2023-07-21 03:23:58', '4');
INSERT INTO `customer_document_verification` VALUES (18, 3, 28, 15, '{\"dlNo\":\"WB41 20220029968\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"requestId\":\"36d488c7-3d7c-4243-8679-26d2e23e1a5c\",\"status\":400,\"error\":\"Bad Request\"}', 'N', 'Bad Request', '2023-07-21 05:26:48', '4');
INSERT INTO `customer_document_verification` VALUES (19, 3, 28, 15, '{\"dlNo\":\"WB41 20220029968\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"requestId\":\"304bdace-a0f9-4d58-a705-c383aab43e07\",\"status\":400,\"error\":\"Bad Request\"}', 'N', 'Bad Request', '2023-07-21 05:27:10', '4');
INSERT INTO `customer_document_verification` VALUES (20, 3, 28, 15, '{\"dlNo\":\"WB41 20220029968\",\"dob\":\"2002-01-05\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"status\": 504, \"error\":\"Gateway Timed Out\",\"request_id\" : \"75f5f8ef-2648-43ba-9d01-ee296089c5d4\"}', 'N', 'Endpoint Request Timed Out', '2023-07-21 05:47:19', '4');
INSERT INTO `customer_document_verification` VALUES (21, 3, 28, 15, '{\"dlNo\":\"WB41 20220029968\",\"dob\":\"2002-01-05\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"status\": 504, \"error\":\"Gateway Timed Out\",\"request_id\" : \"7a46ca40-a26a-46e5-91c0-7a87d6ace629\"}', 'N', 'Endpoint Request Timed Out', '2023-07-21 05:47:53', '4');
INSERT INTO `customer_document_verification` VALUES (22, 3, 28, 15, '{\"dlNo\":\"WB41 20220029968\",\"dob\":\"2002-01-05\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"status\": 504, \"error\":\"Gateway Timed Out\",\"request_id\" : \"480a0ed3-e902-40e8-b5d0-c1cf12119aa8\"}', 'N', 'Endpoint Request Timed Out', '2023-07-21 05:48:56', '4');
INSERT INTO `customer_document_verification` VALUES (23, 3, 28, 15, '{\"dlNo\":\"WB41 20220029968\",\"dob\":\"2002-01-05\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"status\": 504, \"error\":\"Gateway Timed Out\",\"request_id\" : \"60bacecd-b07c-4993-a871-99f95ad08736\"}', 'N', 'Endpoint Request Timed Out', '2023-07-21 05:52:41', '4');
INSERT INTO `customer_document_verification` VALUES (24, 3, 28, 15, '{\"dlNo\":\"AP40720150001826\",\"dob\":\"1992-12-18\",\"additionalDetails\":\"\",\"consent\":\"\"}', '{\"requestId\":\"3e90145a-aaec-471c-b2c1-1166677fc8bd\",\"result\":{},\"statusCode\":102}', 'N', 'Invalid ID number or combination of inputs', '2023-07-26 03:52:12', '4');
INSERT INTO `customer_document_verification` VALUES (25, 14, 29, 20, '{\"consent\":\"\",\"epic_no\":\"RBE1083922\"}', '{\"result\":{\"ac_no\":\"100\",\"rln_name\":\"srinivasarao mandapati\",\"part_no\":\"126\",\"name_v3\":\"\",\"ps_lat_long\":\"6.128847598848088E-4-8.0487821996212\",\"st_code\":\"S01\",\"id\":\"\",\"district\":\"Palnadu\",\"rln_name_v1\":\"\\u0c36\\u0c4d\\u0c30\\u0c40\\u0c28\\u0c3f\\u0c35\\u0c3e\\u0c38\\u0c30\\u0c3e\\u0c35\\u0c41 \\u0c2e\\u0c02\\u0c21\\u0c2a\\u0c3e\\u0c1f\\u0c3f\",\"epic_no\":\"RBE1083922\",\"state\":\"Andhra Pradesh\",\"slno_inpart\":\"414\",\"section_no\":\"2\",\"last_update\":\"17-07-2023\",\"rln_name_v2\":\"\",\"rln_name_v3\":\"\",\"ac_name\":\"Gurajala\",\"ps_name\":\"MPES (MAIN), NEW BUILDING, NORTH SIDE ROOM 10-7 to 10-188\",\"house_no\":\"10-67\",\"rln_type\":\"F\",\"pc_name\":\"Narsaraopet\",\"name\":\"naveen mandapati\",\"dob\":\"27-01-1993\",\"gender\":\"M\",\"age\":30,\"name_v2\":\"\",\"name_v1\":\"\\u0c28\\u0c35\\u0c40\\u0c28\\u0c4d \\u0c2e\\u0c02\\u0c21\\u0c2a\\u0c3e\\u0c1f\\u0c3f\",\"part_name\":\"DACHEPALLI\"},\"request_id\":\"7f9e779f-9200-4231-a22a-15e6f0703a33\",\"status-code\":\"101\"}', 'Y', 'Approved', '2023-08-23 11:34:37', '4');

-- ----------------------------
-- Table structure for customer_master
-- ----------------------------
DROP TABLE IF EXISTS `customer_master`;
CREATE TABLE `customer_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `de_dupe_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `de_dupe_branch` int NOT NULL,
  `de_dupe_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `de_dupe_gender` enum('M','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'M=M,F=F',
  `de_dupe_mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `de_dupe_aadhar_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `de_dupe_pan_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `de_dupe_last_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `de_dupe_first_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `account_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `account_type` int NULL DEFAULT NULL,
  `product_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `product` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `account_created_by` varchar(51) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Y',
  `verify_statas` enum('P','A','R') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'P' COMMENT ' P = \'Pending\', A = \'Approved\', R = \'Rejected\' ',
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  `applicant_type` enum('new','existing') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp_email_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp_phone_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer_master
-- ----------------------------
INSERT INTO `customer_master` VALUES (2, NULL, 0, 'Suhrid Sarkar || suhrid.developer@gmail.combasakcg@gmail.com', 'M', '', '', '', 'dd750955936bed57b9071dbcf73569c3c721822a48cad78110c2f9186bde011ec99b0515c55fef32b6fb1b748c8a4bfe795abe242b19315a119bff42bc3a0aa4uBgDM8zPi7SnWEu6QTAPPwMUK+8zi75pEl/p5mwOj+w=', '8c63beee81e39b9e0737c786aeeeb923f3a0c2608d29ab3fdae3b8fbb5c782170bb5e19a5d0368a63e1397076bf5193b1500949a8429f1f39c7b4b473e45d2a2kw1GTc4Goy6pcBm9L+2HXBqvFaDx25OnFBOxrdFj15U=', 'b68cfcce78bef5850d984b3c70085149357cdec7520a47284286af7e82707ae8ca5453ef16c0257ce7951db0441235af6ff4b07cd6af1c4840484bfb28050baeJtDq71iQVSaLCreJBn+B0Fs5m6Su+1SivLocahbLXjY=', 3, '11', '5', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'Y', 'A', '2023-06-27 09:36:48', 4, '2023-06-27 04:06:48', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (3, NULL, 0, 'Suhrid Sarkar || suhrid.developer@gmail.combasak97@gmail.com', 'M', '', '', '', '1d9ef3ff394c34126dfe0a23f9fc03416ed7fec8ffd53f5299b1949be2fc4ed06ab4e9008f9ae18193b1ff885c4b62be835312c87fa10e5efa7c06532d6e8dbarH6v6BX/tz6eMaiQ+2MamiwDvQpa9O+2QvhFlpCFeG0=', '925f7d5c7d9cbfe901bc053470ff0add2f951b234b3e432534920d66633959a82e32372c8c0715dab42f72c1209a02cbb6d55ec067f0dcdcd1989ce152d1a82aKGza47l2psxM+Bsbj4CM4GMEq17iXqkSNdJq0GknG4g=', 'bbf90b57cd6a9f2b524f95a570717a691c39df30bb33c75fa53aeb0863bc7a187f35254ba159fb6e609a98530b2bec27202a688223dc2f2b2d119d16f390d179fDt0qjElynqTXwyxnAzKEJ9ydNptLbvH2no7gFVMUC1zjWuRFzEcrqNydeqPokXqo5U+TG70BoyFPyx3BNFu7g==', 3, '11', '5', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'Y', 'A', '2023-06-27 09:38:07', 4, '2023-06-27 09:38:45', 4, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (4, NULL, 0, 'demo@demo.com', 'M', '', '', '', 'e4df568f08a6172909256a55cec56858c1495d0bf6780245883b095c7c7705a373b1e72478c9eea7a37bb828433d68b07b0e98b8cf2dccbd1e36b6885806c3ccfxqbPhQlUk1JUk6YVPbx2Li90vIbKOyTzvwbsQUtmPY=', 'dfd19a5fa7d9807972e3d4734156a203fa9d0f082aaad82ebcb28e930be2eacc30f86d6cd4d098348a85497e8d8c344182ceeb2df05cf32f2b29f9ac6cd8d9b1567fMCfqTFAHbKu/z8XbxJwxpHEZhO5EnUCUt1y7ocM=', 'cf6c72e0cc14c938c70fb5dd986eb21359ca35a60a37961c28045606d3e326c290c4a22a801517f3a5f7cb3a09a040b6518ab9ed1da7b130f72bd0a3d504f645LjY9b5/Ex3o0jn19NhEV+zg2hmJ/PDukqshN8LkVSsM=', 1, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-07-21 10:46:29', 4, '2023-07-21 05:16:29', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (5, NULL, 0, 'newdemo@demo.com', 'M', '', '', '', 'f79a572efa899ed118d2387e2b7d8c15072ded8bacb739ce014b623a910aada95303c6541dc91a354eb10881d4fd05e651e1fa8380850a4446b388d32f98479dmfOOlA1QymlYqwsZVKVFaEg9ZSeDy5XF9D8dTX/aXOc=', 'f3410ee4b5e760242a6e4c5f3ec43d93fd40e3da209442eb84fc1be6cd2907722fda723bcb0a7b341db067a2d656f69a82667fd246bc7db4da77a77e39a39861cQJpwbLESYFASZMZIwg3KmpLDlo5iku9IOQxxebdE6w=', 'f58db2d1be39bd9cd91640cf06a6edece60d6146c9451088ab2a1bf3a857c546b8b2580483d519df8022507a6b943fde889c1787797b995aaff5432023908393/CUytsq9CZaSjNsudca1IoO69/eO7+WcSxraKqFAtW4=', 1, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-07-21 10:47:32', 4, '2023-07-21 05:17:32', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (6, NULL, 0, 'sd@gmail.com', 'M', '', '', '', '64f1c075f3e7c6fb54fddca367cfaa0913aef579b2702a60b1bec3dce292b3f5dd61ade66e14a3faa06bac23cc7098a1ab06a1e8d1dc01d78657dd1debacf2a6o944NPv/HUqhEQx3gXiIP+GgySk+RaiGM3rYg4fnaXc=', '9d873164c2a7b224039b00108a7c32fffdecc2b62bec42af8814548477c6be7c0f3c8606fd7725eccf5acde862104eede18f78b8bee1f0fad3bf5d3657167d69/4l7JhNZiGLO/j9sVrtLmLZKxm4iygkZEHMNF1x6ONc=', '63c5c3b59e30443b890e269e6962cfae2bda4b734f9d5350608d60bd10ff69e38e1ce01e0366e99d31bcdae8e68f24c2b27e0f2cc9ef8a48e78aebeb62ff44ecVAFUDQJ7TeLfGhekTBnKPQHCtdWG2Jr9JUu/rIKj8yk=', 3, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-07-21 10:49:10', 4, '2023-07-21 05:19:10', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (7, NULL, 0, 'dfs@gmail.com', 'M', '', '', '', '013b1c338af06794fa9790cf1435865b98a27a30a3fd36ccf673accfef066df55d1dfc39db685cd3fec7b5d9e3b778e43f91aa361db2a2e802ba74ac5a117ef84m0PC4BrRPCKmCSzFScVgHXNlQ5AAqgV+JAgIhSh07E=', 'bc7cca8fd73fe70bfde79a50afab7b6b6faddc85642f34b929721b9c2964f2f26a9801d89eb40706e2b880a06fa867550deee62fb4e45deca5ab6660d9cbe83aKAzX9UU2fD9BCM92JEU1QaZlrJBGvV42VT5jjS2vCWs=', '0a2455930451ea44b0c22623c18d9845d45b56920a4bf4af2da56c4fe11fa20ef55723985df60d756f71279d53c4d5866ceaea93e5fc95ad8ddac825006da0fdZ0rI49EmM3ij+JP+lvpN7aPvcipFXhyB0iwRrKSNLaA=', 3, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-07-21 10:49:50', 4, '2023-07-21 05:19:50', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (8, NULL, 0, 'naveen@somayaji-group.com', 'M', '', '', '', 'd686de4cf4d9c456da507ca8da8b57659231f3516100495de66dc7057288b7edbcc818eaf48b54d415290982a2970a880175c3538f08c740dd6a6406f8a37005V1hVBSsfZHPzngn3eBH/rK0gtDco9p130oWJRhxMR6s=', '2812fb4c4c496731b3ca9477dfcda9ea88643a7f1506ec6bc577b2e09ae664c0911480753632e00b3646c5735d1011b797c6f164b13d8f4e833bc908887df7e3f62sg8hgDLqvrb7OmZVLD4Ssk2gnpkydaBduE2H27og=', '4b1ef5fe630cfd8a2cfe42eb70bd816cbbeeb6a9c4005a4d14247a4e13a9fe1bc41e64a72d6b004dd0b4aee1497360fb8c5aede29952a1bda1cb640d4c0cc5f9CxZ9Rr6pQtG6rCDcibP0+vBISNjt8/1l+XX4cHOScAc=', 3, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-07-30 15:46:58', 4, '2023-08-13 15:47:46', 4, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (9, NULL, 0, 'naveen27g@gmail.com', 'M', '9642032106', '', '', '3e6e989d2c0e144987b4fbb4a4dd49bf986023e16d83041a816e09cd0336c4045f8fa756d11a57161dd619d15b52b28772327d8586d7c4669da36e5450bd8072MX8PQ+66K8Fmi4a1PmpdPkN1SvRyUyHckWnwMZdoB7g=', '5e20f116e8cc74544682904baf11d56f2fd20fbf8c566e38ac36041a47509ab59fbed769ded7c66e92fad0795a21c2893ac2762fd51290b01aa946d27807846dEb2xVFrK/SOwh7OJpvMyIwbEdPZmUJ8nz5lmS6eioiM=', '04d24ee967cf3785b3d7c495fe48caccace5fc47e8f642ee1de9ef35b296092c88ab1b9102ea9ff7128956d9ca9b2878107ff71f0fbe64127d4557c9a876c282S8RpMwm3+NYkL9w9XuXyO+AJd+/dGSbTnl1Glo9QBYo=', 3, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-08-14 22:04:42', 4, '2023-08-14 22:05:32', 4, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (10, NULL, 0, '', 'M', NULL, '', NULL, '7ece7fe3e1fe20b36fd867c7bb37f66df48f54588bef8b8fb52695a785134c3f38e8054cc672905fb43e8a4419aca750217357a301702700ff42f25afd56a11709Qt1anWOAghHS+HUl9+yPTtB/3n1OlnQSaWom8X9UE=', '6cff146086baa4a2d596b9fd5b8e1a4e0cc2da56d15548cd71373f014aa293163c4616efa4f09eb061dd7af6c0be6897e9caf2f0c838c38d925b6d7c8bec1e0b/Z8ZfWMzn/TJcYeUlMeJ6n7Rt9SEdGjhe1yKOgtLFWI=', '733afe35853616062cb06511e380992a78c51823fa164a048d1b77fc17043646af1ef235fa8b2763603ea5ace6baa03abb16b3502bed9f600e6b2bf94d6c723aEXeFUKQWZOjmKsA7PW1co6DiuHxWrmL3Wg1Q3nkmLT0=', 3, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-08-22 14:37:27', 4, '2023-08-22 09:07:27', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (11, NULL, 0, '', 'M', NULL, '', NULL, '6d7f1ddf2bf487239a2e2d72f86421b9af7ca4a586b7eb538dfe9baaa4815cc1f5ada91ee221d2af554b3b91e3cc4cd07e9cf57fc2b077b7cdd4c987ecf916cfyNX5viCBvcTYbi393CTVDtMq6EDWhE2zEOi8OoUVKwc=', 'ddd3d0739045742de3f66029dc5180b15bd2ac5acb4e94b780602800e70fc18c873744baf1d657ffcfc75316c27d2402c8115a2fcd7ce697b2dfdde9ba22a65dZdy4ntb5u0ZXvFUmDaPiDwOwifdAuz9wmQn6jWfXKao=', '865286ec0e9ef9b050fe5f92c67265b0fec23c07c04600f53249d639d073d9da57f6a5a66200975906e0cc0c2775c3076949218e9ea8a495554d427d42f04c86nXwh5nrYdNglnT7jlq2DC4DZL3R0C3uz/xPKhS4ylfU=', 3, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-08-22 14:37:33', 4, '2023-08-22 09:07:33', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (12, NULL, 0, '', 'M', NULL, '', NULL, '9106694da7cac7bf3e553302689d96a2111d9029a7734a25da799d595184aa3a9e10a8c865969e509b27bb4dedeba6cd3c7b53372857b9621c8263ebb5204091AvnX6uRXgK8zU2NmO2Ch9QQm4S9/zTMl+3Yob9LCreo=', 'd08c5a0dea463a2ffb599a60ef7590498c064b40b14d6fcf88828e19611fee861a59324d2385136c040e3b7b5cdf22186b475f1eef1efd02235ce701629c11a8Y4+BIQ8vMC+otCGNaY65piLemq8a1Fs1wLwfBYve7Uc=', 'defc6e992f4d955f8085c95db19ed24d0b1e255fbb18c74c846b8765bbe266fd637717791874c0bdc09f1b8316c67a2dc6759e4cabf6e274e46975ff4bdbc3a19Ihi36JopKaEhf1pApoDebaNHm33QRvFycXrVo5twOc=', 3, '0', '0', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-08-22 19:49:30', 4, '2023-08-22 14:19:30', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (13, NULL, 0, '', 'M', NULL, '', NULL, 'dd8038483136f11af15a7fd0205563c59af9bc010ccaad455a6be640c046145ef0bfec849579b60f1148a95563101b660d716348e9b67984019de1ae6e6c3a72RnLc+xHyX3evTRc51Pc3xVncfelxikcoqo8Qvf/xTmU=', 'a2c6cf611d31eaa6c3c30e1fb8f0da28866fcaab323ff69d187b5d70a463168c2e3c516ae2d853bdd2bd490a2b55a444f4707212d06a7b02adeaee1e210917b0rGiIxKzY0bq9nx0nRNuZpGXKq3UvxpagUnammzMC7kE=', 'b4d3d96caf88df6ce42afcd2e0c7824f8ba843f220256499ae4203c9accb412f8a6de573247b6147ad20a5940688fa69d42bc20c249799f36f57cf0978c51f58jHuOyhZmIESvy0mLweaSDNq4OR12TZcNjc9BUSe3XgQ=', 3, '11', '7', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'N', 'P', '2023-08-22 20:23:53', 4, '2023-08-22 14:53:53', NULL, 'new', NULL, NULL, NULL);
INSERT INTO `customer_master` VALUES (14, NULL, 0, 'naveen27g@gmail.com', 'M', '', '', '', '4e40a7c6e4554e751722e791438e605aaab0ba60716be872661b735dc3e90c54d7917f0ab0a71a942a5ffe55dfc0d28d03012635ccba2d77dedbdfd478c91de5sjwDz58Jop8IiGRP6M+KrrkO23roaTszWYfgDij/rZ4=', '03f713a237dd48375d5cde28b5778bff7d4c96570f8fc8ae7daecec0150c3137e2fba9ed6e6801340d236b27314486fde5d517e7faf6b1a9659ad0290e09df8eBaOEMVpnURpQ/M5cItPJIHMU7GJIWF4IqmNqQ0qEiGM=', '0674ee2e5705345b7b0490f6774d2318aa4ae9a78d89f368877d279c7aff5c1cd8fddb43c5b3e901a8b15e8c172b8dc1598a6d130495fec85ba90338ad1ed1517F4TOq/sEiGC75p1X9CiD4/YFun06olLY6E+ixwcvn0=', 3, '11', '8', '81dc9bdb52d04dc20036dbd8313ed055', '4', 'Y', 'A', '2023-08-23 11:10:27', 4, '2023-08-23 05:40:27', NULL, 'new', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for de_dupe_master
-- ----------------------------
DROP TABLE IF EXISTS `de_dupe_master`;
CREATE TABLE `de_dupe_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_type` enum('D','L') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'D=Deposit, L=Loan',
  `product_id` bigint NULL DEFAULT NULL,
  `field_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_name_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `master_or_value` enum('M','V') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `master` int NULL DEFAULT NULL,
  `is_required` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of de_dupe_master
-- ----------------------------
INSERT INTO `de_dupe_master` VALUES (2, 'L', 5, '4f4320fd95b36dd7cfe7c22578eed499e7aab7bee5dc2ab015f8534ed9dfcc4658261e69b225e6c4f4946a2dc75f48795f58667c7d7c7b4fb6f0c48c4237813c6pT2qNLX5TR5xXstVS95IVN8kcc+kQyzoHYf0tqZUz0=', '833a9eb5acddf4ec51eabccb158d1daf03fed25b06952c47d23fd94811cc2eddd18e784b8191949c8316345135d56a26f5fcfe2bb2870bce4e515c66d09aa8acM+dmHSwIDWZBGNwU4vAx0Hwf3r0ynALf0rdzArmtgioDS7CXrVOILbTxNYoZLFOF', '80e302a537b41a260040e8cc8e3f75e1301b245cf028477e12db14300207a06fdeacf7273b159e398bed6ed3c66b6000aca1838071af37f5a68ec2b8d66ab4e8gZCYnrlaMaEWtoyAkgA3GgmqOI7R3MAQfzZMaXkm4EU=', NULL, NULL, 'Y', '2023-07-03 11:33:45', 4, '2023-04-12 12:35:03', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (3, 'L', 5, '52931667d603a5b8bee8211fed3c21ec0285bd97cd4131a77de1d141cbb237c5a6097ab42b33c30876b599e9b343b2fc90764b928738077fad4566db0c8b439fe6rn4e1pYFDCPJ1KlLHBqURxuk50GUvqpOXzU4a+wlA=', '4572ef6f54f8131fed1e16d5a3ec85faaea0b1b051b45a142359f3597f9d54abe31d88d59c7958450b8f3ac50b788b692b262d9f316baea2d4c82fd977ae90edzsbFcSGqDCR/Rw5XUAH3dIp+HcR3SSbaQhlqsL6lZTIBhsWGuucPFW8TcEXlWOHj', '2851888334a8bdf071976c58c16d41cd0708f38984dfff38440e7f4cfa9094c817aa6ac9f816bd357bdf152c775b282d37237d464a1dbb36fa43f54d95b950f8wHzSxVYr877oUSWUm597WAkbWgo0r5Dntb+/TDGcGR0=', NULL, NULL, 'Y', '2023-07-03 11:33:24', 4, '2023-04-12 12:35:00', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (4, 'L', 5, '95c5fdd9e90a8293a41a224f961ba8f1adca8481bf4c668bf2c3ab61028aec959cc2c79550377af344f48d8d59dfaeecc9a7a6845c3577684eacf8fa93e4d9f4DXMnoyXVr+aXqn+jCm3vdO+Ak4zK03L7kZTH3xu0tRY=', '1f83a26b51f150f50a608b164f49f7ed3eec2896cc9d8efb7ab855a798f4bf6229be0b4e274c2e526842c5b246cf0be90acf97bbbb9c424a2738d2400ee658e9kFRKo0Vv2EZ4MvkQKU7AAXEsS4qvUIJjORfI+0vfap9PTFv7rhSmMprFhnUo8IT6', '1d4b7417fa4bb8cb2041059d8fd703f4fe708adebc224d3aea702715ef4dd38f218292b556c25ee54b8f33b53afbf84e5ee4032a097e321073809a9d505d240cp5iaGzatZE/WZ57rxHqx8vBy/FmP0yMTGcQbuiY72EM=', NULL, NULL, 'N', '2023-07-03 11:33:14', 4, '2023-04-12 12:34:56', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (5, 'L', 5, '276d8f0ec51151fbef861442df7a5fcec4df52046ffcd8dbb35bf5501d75e868aabff192766e0da52969db1cdaafb38b09e6dcabc43a5daa6c14c239889efa10ACSoZqhqTzqWq8EysV4IXSbyrV+kYalSeL+gA7vIEyk=', '56fed9bf9e99e286f5fadb302c8d93193d25de9792ea4d7442df64567eadbc4d84f303f6ac24f8be9e19ee8fef9d3d7d7fdfdfcbdc688842ab68149071396ac7IIYSPix1f5tvxuvx/W07lB/hONt/h0DLekGzuhXy29ZojdwgoNsk9e5OEdo8k2Z1', 'e046ff0d0a0e88ddb2234dfa6ca8fbaf23bb63f6b66db42f0d438473e065bf78829027b70764ecbb543f9c73d4c0c7bac73964702b7f365ce3746004b144c311Wd91hZojwXjrclcEvGewhqEKNU9vptrfcGcnomWPgiw=', NULL, NULL, 'N', '2023-07-03 11:33:04', 4, '2023-04-12 12:34:52', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (6, 'L', 5, '42d40dcbe75479fa5be9085075835066511f487bb2a366374e4977d8a8b8899027a52ca38d758dbf330eb445f059f3ae54b780d9b7644520b6f3c71d157dfe75iXcznAKB4LCsJ/EAGXn8SvPcFEF9gioDCcEq//XPWmU=', 'a0fef9be06036f89fc147946892fc75ab91fff0a6384784a050bdbcc77596f9e5352fa5ca20b318dc4bad96b9e7263c35198e9501e07043dce04c0908912bea9ATwz8mv9KkxlJZ3N3hbQOEZgCIzx7mSzkw9vg5p4JinngvX6M0VGT/cxMl65vNjM', '30eca5df0c674f5350ab0464614374abfdc9ee71f775d7d7896199cd964920d6bad1a61359504dac633eed92bb91351152573581bd379a1274970a4e71aa0ddaTRqHv6UrGoBXKrRj0qGo6fp0aTNPA5IqqxmGSS/Cjog=', NULL, NULL, 'N', '2023-07-03 11:32:55', 4, '2023-04-12 12:34:49', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (7, 'L', 5, 'e50031f6093d9ced07e7721a7b4abc4381f0daff8a94105fa59b3d1c9005a3c7ab5a4ef602ddb6fdaaf1c64869eb9256b809022f3ca1bdf6f3c9a3bd1684788c3ckx0CMOxVyLiwWyurocc+3r+uniz5lD3KUhCfNseRc=', 'cdd7958cb4c5deca56e0ba5f4b3eaef09550aba3dbf9cc679345cc0cec3195670af8b78710c99916d396719605b9f10db00133cc54a46264af3235715b018fdbsnw8K9AUBMXtDmMEgLx4lMBkKu83AYcD01sy8KtG2qE=', '13a0a05d6c95038ac24e1f38ce710c95af6c2fa9544afd8f8082f20af8aedda03401180f87c54e96513d5c1611cbdf90f65875bd521fdbaa110e8eca2fed25d3FrjoBkLd3ULgYotewaXUTeaXWdKgf6gYK3//Q7do99w=', 'V', NULL, 'Y', '2023-07-03 11:32:13', 4, '2023-05-08 18:21:36', NULL, 'Y');
INSERT INTO `de_dupe_master` VALUES (8, NULL, NULL, '89e44b0c3c6665f3f6df7e13ffa7d598e721c56555946889ed34184e5798ecf1b241f383bd249de9c2149e4dfa674dd13ffe459e22609b6072c9877266bd63d2g62kMy2YR/tdea84hN3s06GMIlLRfkGH4qsYPbipD/8=', '2096a4b756996277a6215c9e09e8fb6da0a4ef72ac66229578ee75d3a2a325ee172797f00c344920597262830e40aee221a035f54869ef6273eb18e67e471351NU4hs6xuy0Qese/KBbvLN6pF1vdHQncaJUy0fDjEUV0=', '2c5824aa14d7582573d3cde87878b1f4e39b0c75d82fd1a84a51abef6c370bae8c68d782b6a85247dff7df155a206f37767e877b211f62810fd6b092409dcab0g1AZ8FAV0LM6B3Yw83Iy4F29t0PziNmxgBs8XTOc0bs=', NULL, NULL, 'N', '2023-05-12 18:03:49', NULL, '2023-05-12 18:03:49', 4, 'N');
INSERT INTO `de_dupe_master` VALUES (9, NULL, NULL, '91bb3d5e526fcc6631f53c6d220aa94bed4d222c4fea5d357161c3f53740e0200aae4096ed9c196fd65306c11bef17e3e8f59daf7d3e9bc78c9d3e0d875d3eabtwZgePKTDDfnsUZmxK0AgWipgMzNvhRwFIyIWNAIoPQ=', '3fa412dcbe59dec40ad6b9d1039ab6ccaf99e729ef9003043896cdc90c9ae819654c1aae5440a0caddf8d8ec6cd91fbeaa655ece455630dc307f475365429813AXm1cLv6Peb8T5IA1mgOiLo1Abcmsp61uPpWzdDItwo=', '18fe9a3cfb7f63db70e973f8297a83116df14012e4612394693df3a316447fdf25a5afa455ac7a1bae987bc805eaf0dd3a622e48fc0337f805bec38faae3c923vTMoS0/3DsTG8JwZ4V7KlA0NPAe/6hDLMFkYbJBqHs8=', NULL, NULL, 'N', '2023-05-12 19:05:52', NULL, '2023-05-12 19:05:52', 4, 'N');
INSERT INTO `de_dupe_master` VALUES (10, 'L', 5, 'd3f9c74f56c9fd6e5e54cd2a9d3094406d4190f64b3c68e6378710bc5e7a0cafffba3883c51cbfed181a11331f09d23ef1e2f4e96deed872197f74098b9f3f81H4bCGDM1pNMt/Qr241djwLlf5Xaac8/KGpa0kBKOFFE=', 'f71773170acaaf63661eaeb04363342df164537d40c62802016a977222a10cf46219c8be3d3c2b448e6fc70312a8c5931dd1889b29c6fff6b95a9a60a81fa6a2Upp8LZDiyuci+djlM9kjLcKD1xEsTR9jsnjCgpYosGQ=', 'ed9a9363474ff6ab92b65f0b4f78cb3f74a51954a36c7726a0422d03657e2299539b1f669941d0fdd613a83d780ce7e7e0ff133af46e8ec610bf7b70c91ec7bcN9pIp8xdDgF4cXUqm80AE1+ibA5N8zgGjUcUXvFo1BY=', NULL, NULL, 'Y', '2023-07-03 11:28:45', 4, '2023-05-12 19:09:17', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (11, NULL, NULL, '4ccc834e1f54d903ab3a98cb1134168eb7b738df9d306083061d4aa6830fa73337f22a9cdb5f1f6509bef1542235cb1253a27e4c871066800bbb117eb13dbaecUUIqr3ha7COvk94MEEwxofbFQURE45GtP4F2lyY+ZA4=', '1505a548c059f09af12d0643bed9cebc6ef93efc0a2becac4fa160b9f38a54d55a5635319e673ed3148450e21a2f15e25decbfeef260700a9f5a0d3d8b156401EEJiW4vWBEMO6I6uIMzxZL+knfMGBhy5/wlHVYzXB0E=', '418c8a25717254498d92f55822bd33bb2cdc5876908c7469af6b108c80076a57dfbf387694cd46e6c74743f38e406f17ec0a9c11bed72ede5b0d2d323f658937Y2TirO47zl/izztAvQwWHtlZnRBU6dQGtwIBy/sLlpw=', NULL, NULL, 'N', '2023-05-15 04:41:38', NULL, '2023-05-15 10:11:38', 4, 'N');
INSERT INTO `de_dupe_master` VALUES (12, NULL, NULL, '5817f469e5301b2aa8dde56b59d2e4d0279e224bfad154ff7735498875eb9a0624658fe7979a8a16d5f95c248bc226258c61a2628ea80b602f2c6c3e06f1fe1f8hiBc2iQbWxnqTHqBrI2qnpechzKv4BgLkJN6Q4HWFA=', 'f4b6daf73571bebfa67382e75de1376a0a7b8da3f2994dcf8cdca31b7f15f858ef0b2e23ca22e674c89f1f8d3a4edb457db451ee7dd9dde1f4db31354f553f83lZb1SBdsYj4/bNX5p7c3Oozg6zkg/66QHD4JRiAWb2U=', '960d40928ce7e2f2374260ab30c7615c7afa45188f45db24dfbc81dd78c0bab17d42c46decd0ae5adcc68a3573d604691bb28f0b78efd881b0cf9749cceec1b23MaI7LAKBkbhMo/7GTAFYIFNuZ9al7Hitlu7GlSk4lk=', 'M', 0, 'Y', '2023-06-07 14:40:48', 4, '2023-06-07 09:10:48', NULL, 'N');
INSERT INTO `de_dupe_master` VALUES (13, 'L', 7, '1f2a16dd3fd95ca1866f77bcf63a9674d79f08b024b9fd27cd629d9c5bda8763b0b5e9441ef01596c34a2f01f836e121cf9e8e2c0ae546f57d9ff6226e53c150JbSQFI8189CcAcZiX9H7kS+QIbTjKzap3EQgGymmCvc=', 'e524ed2e1d89ea14f490b0a8d1487e44103a75d3d15bb1fb99d642a9389ad32d130dace6e15980bd4e83f13b20097d6f9103a32123dfd884967ec161295acfc0GDW73RSgv4J91rqqIjBIeUGK+/q8yxsOWxlcpeQHp7A=', 'e0950b927222a6006c2b75c4182ea6837437233c3c0b75e4fcddbc2a9e4c83eaee5d4e0c40d3ee15d9e96c42a24795a0e55385791f95afc5e7f7446a43407ebfe/SfreRpavmSKfRiZcSc7OVUmKNUgPK/GYc/JvCAwn0=', NULL, NULL, 'N', '2023-08-15 13:59:51', NULL, '2023-08-15 19:29:51', 4, 'N');
INSERT INTO `de_dupe_master` VALUES (14, 'L', 7, '3d44885ff8187ac2bde574946d2cc646bd8425881fd8d28682289efd3d3fda1f19b1d3592b4539e1a633f0018fe9d7ee2ae5340da3cbc8b577b0f8cb49da61fcqRJFjnVZmhOk5jAmCifTLr1DiK2mUeMMecatfptqBMk=', '3ce35f1d42c77f3e64cd5bd2d6b79bc7ac03e21fbb6a2d3833f35b8392504596bbf04260f2879cbdf1cb771125a93e4c07b407bc2871d8815ca833514ac3d799dCuiaurvq1Z0dQ+q3z2v5eKCgf6tt+YPsqa2r1tW2qzix44JZhlTjm3bBoICdxVq', '05bebc6a57374607e3e043d69eb0f67ef1183bd2ee723ab0ac60379a6b364b22fc3f51491a7c7a0e71f886743daf29db12008b2b8b61584f636d46f83898a3739zzs/7SPRHybAdk6r2M+OR3BdM7zOMXfHQYwBh48Wk8=', NULL, NULL, 'N', '2023-08-22 08:20:58', NULL, '2023-08-22 13:50:58', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (15, 'L', 7, 'a588c5b5300cb20fbc804299fc30c9d900f345e7577ba7d602783982b71b359806c6a71f884a0a73a508a562ecd4509a99e4e6355c4f41c65f52c139fa546fd1Hu4oQ1vN4BnF7kqe/8+pwBVjs7sepuIvFIdLews+WgI=', '70e99be44a495adee6f00b992c265f6d4481b393e9ea6362178ce0bcfb1f50bddccb80ec48654e9d35b3883d7567fa773782729650a07a50327a6cb0981afcc26BqP6ZqplDOqCuAuzOKWBqkcKe7AFMvMjqI+XMWrm589pW7xYyvjbnu63UssjqiP', '0dbb339571d2c81a9922117812daa3ce4afb7c03b5074a3452caf46cae70700b6ee9f4d03e8f2db2d37b7f8559dd7cf97d11b47c8e8c1da95581bd18c74f9a87vh/H8AHF7nxN/XvqJlIKHcC/hrdExfxRffhS8X9SkZ8=', NULL, NULL, 'N', '2023-08-22 08:21:25', NULL, '2023-08-22 13:51:25', 4, 'Y');
INSERT INTO `de_dupe_master` VALUES (16, 'L', 7, '41bcf413dab5397d16848e1e48360290508ee1c99d03f3e307fe9d567a346d9c3341f93bcc86d0c8456b3b473c80794b9fad4ef006bb61e64a3b17194450b125uXXdv1FbsbL2rEMyz9SYxtw5OknkEEpKxkM6eWLTz4k=', '56665558863615c44cc295b7beccd3022715d8c508f58eb90f025f198e4506736d843674aff11c960783365f6371724d7b2a18f70685f18149cf169b014331e6WMuvptQD568TW5N4TmNi0MgYNuIHd1mYVs/fROKLg+g=', '6cc03663752187e52cfd7bb89574eeda1fcb60588214e18a54fd53622c06ae0e0d14eee59dd93168759cb82ba288bdef672c1204abf2bcdbf8eae2361d54daceBPaUSqCjK2S8rfiUKCicYOlLtIfIG93/PlvSTkmv8pI=', NULL, NULL, 'N', '2023-08-22 09:06:38', NULL, '2023-08-22 14:36:38', 4, 'N');

-- ----------------------------
-- Table structure for de_dupe_master_select_value
-- ----------------------------
DROP TABLE IF EXISTS `de_dupe_master_select_value`;
CREATE TABLE `de_dupe_master_select_value`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `de_dupe_master_id` bigint NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `display_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of de_dupe_master_select_value
-- ----------------------------
INSERT INTO `de_dupe_master_select_value` VALUES (1, 7, 'af64fd2caf3acca85cd26125f98889f7f40cb56c1f03b2788e51eafd9deedbead85325cfe0b29a31c056a938b1532687abee2163729bc0816faef73db476490b3utRG/CC6cq5CvgsES7gp4l8SHXg1iJyT/d3El4p62k=', 'c1b8a5bb276ae1962250585e6c75058bbe632b69fa6327e514931386f50049e2dceade9e33268de0ee8857769057741cc6adcafb19d38cd5112106c9bf42f8b0BgeB8vCI0ZnsQmS2EGRqGSd2l+IYVfpX3gc29oA+FVo=', 'Y', '2023-05-08 18:21:36', 4, NULL, NULL);
INSERT INTO `de_dupe_master_select_value` VALUES (2, 7, '8faf6e529620f8b8acd3221d686ef607f4e9cb9113056ea7d97fccfd3f1efff6eafce93f1a9fdc23ad1a0dd471aefc1af5e84f02fa047274b4df9077dd94498cUiLf8r/kJqyaTx3w0JzVAJHXJ7naE8mabGoAWwqSoGY=', '1326c1de9dcad341f4421c3b6fa1329b5b3f7ccf005aa890e37292e5fb36bac24a83b6c9c886e9b710438d3a56ccfae8ee4054eea02d94e866bb1461038b8f1ds5NI5XEJP6uiUQGjbYpmT4gAZ+QrQqnafaPk5mJcRjk=', 'Y', '2023-05-08 18:21:36', 4, NULL, NULL);

-- ----------------------------
-- Table structure for document_masters
-- ----------------------------
DROP TABLE IF EXISTS `document_masters`;
CREATE TABLE `document_masters`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_group_id` int NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `document_type` int NULL DEFAULT NULL,
  `document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_required` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `created_at` int NULL DEFAULT NULL,
  `created_by` datetime NULL DEFAULT NULL,
  `updated_at` int NULL DEFAULT NULL,
  `updated_by` datetime NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of document_masters
-- ----------------------------
INSERT INTO `document_masters` VALUES (1, 11, 3, 1, '1', 'Y', 2023, '0000-00-00 00:00:00', NULL, NULL, 'N');
INSERT INTO `document_masters` VALUES (2, 11, 3, 1, '3', 'Y', 2023, '0000-00-00 00:00:00', NULL, NULL, 'N');
INSERT INTO `document_masters` VALUES (3, 11, 3, 1, '4', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'N');
INSERT INTO `document_masters` VALUES (4, 11, 3, 1, '6', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'N');
INSERT INTO `document_masters` VALUES (5, 11, 3, 1, '2', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'N');
INSERT INTO `document_masters` VALUES (6, 11, 5, 1, '3', 'Y', 2023, '0000-00-00 00:00:00', NULL, NULL, 'N');
INSERT INTO `document_masters` VALUES (7, 11, 5, 2, '9', 'Y', 2023, '0000-00-00 00:00:00', NULL, NULL, 'N');
INSERT INTO `document_masters` VALUES (8, 11, 3, 1, '26', NULL, 2023, '0000-00-00 00:00:00', 2023, '0000-00-00 00:00:00', 'Y');
INSERT INTO `document_masters` VALUES (9, 11, 3, 1, '25', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (10, 11, 3, 1, '29', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (11, 11, 5, 1, '31', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (12, 11, 5, 1, '24', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (13, 11, 5, 1, '26', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (14, 11, 3, 1, '27', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (15, 11, 5, 1, '28', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (16, 11, 5, 1, '30', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (17, 11, 5, 2, '41', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (18, 11, 5, 1, '27', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (19, 11, 3, 1, '29', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (20, 11, 5, 1, '29', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (21, 11, 5, 4, '21', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (22, 11, 5, 3, '16', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (23, 11, 5, 2, '38', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (24, 11, 5, 2, '33', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (25, 11, 5, 4, '22', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (26, 11, 5, 4, '23', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (27, 11, 5, 4, '23', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (28, 11, 5, 13, '74', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (29, 11, 5, 10, '70', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (30, 11, 5, 11, '71', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (31, 11, 5, 11, '72', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (32, 11, 5, 2, '33', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (33, 11, 5, 2, '37', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');
INSERT INTO `document_masters` VALUES (34, 11, 5, 15, '77', NULL, 2023, '0000-00-00 00:00:00', NULL, NULL, 'Y');

-- ----------------------------
-- Table structure for document_uplode
-- ----------------------------
DROP TABLE IF EXISTS `document_uplode`;
CREATE TABLE `document_uplode`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `document_id` int NULL DEFAULT NULL,
  `ecm_input_master_id` int NULL DEFAULT NULL,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_by` int NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 60 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of document_uplode
-- ----------------------------
INSERT INTO `document_uplode` VALUES (1, 8, 1, 88, NULL, 'Y', 4, '2023-06-14 18:10:41');
INSERT INTO `document_uplode` VALUES (2, 8, 2, 89, NULL, 'Y', 4, '2023-06-14 18:10:42');
INSERT INTO `document_uplode` VALUES (3, 8, 8, 90, NULL, 'Y', 4, '2023-06-14 18:10:42');
INSERT INTO `document_uplode` VALUES (4, 11, 1, 91, 'pdf', 'Y', 4, '2023-06-14 19:08:35');
INSERT INTO `document_uplode` VALUES (5, 11, 2, 92, 'jpg', 'Y', 4, '2023-06-14 19:08:35');
INSERT INTO `document_uplode` VALUES (6, 11, 8, 93, 'jpg', 'Y', 4, '2023-06-14 19:08:36');
INSERT INTO `document_uplode` VALUES (7, 3, 8, 74, 'jpg', 'Y', 4, '2023-06-16 15:39:25');
INSERT INTO `document_uplode` VALUES (8, 15, 8, 76, 'jpg', 'Y', 4, '2023-06-16 19:07:05');
INSERT INTO `document_uplode` VALUES (9, 16, 8, 78, 'jpg', 'Y', 4, '2023-06-16 19:43:03');
INSERT INTO `document_uplode` VALUES (10, 12, 8, 80, 'jpg', 'Y', 4, '2023-06-16 21:09:32');
INSERT INTO `document_uplode` VALUES (11, 18, 11, 87, 'png', 'Y', 4, '2023-06-19 12:08:51');
INSERT INTO `document_uplode` VALUES (12, 18, 12, 88, 'png', 'Y', 4, '2023-06-19 12:08:52');
INSERT INTO `document_uplode` VALUES (13, 18, 13, 89, 'png', 'Y', 4, '2023-06-19 12:08:53');
INSERT INTO `document_uplode` VALUES (14, 18, 15, 90, 'png', 'Y', 4, '2023-06-19 12:08:54');
INSERT INTO `document_uplode` VALUES (15, 18, 16, 91, 'png', 'Y', 4, '2023-06-19 12:08:54');
INSERT INTO `document_uplode` VALUES (16, 18, 11, 92, 'png', 'Y', 4, '2023-06-19 12:22:11');
INSERT INTO `document_uplode` VALUES (17, 18, 12, 93, 'png', 'Y', 4, '2023-06-19 12:22:12');
INSERT INTO `document_uplode` VALUES (18, 18, 13, 94, 'png', 'Y', 4, '2023-06-19 12:22:13');
INSERT INTO `document_uplode` VALUES (19, 18, 15, 95, 'png', 'Y', 4, '2023-06-19 12:22:14');
INSERT INTO `document_uplode` VALUES (20, 18, 16, 96, 'png', 'Y', 4, '2023-06-19 12:22:15');
INSERT INTO `document_uplode` VALUES (21, 18, 11, 97, 'png', 'Y', 4, '2023-06-19 12:24:18');
INSERT INTO `document_uplode` VALUES (22, 18, 12, 98, 'png', 'Y', 4, '2023-06-19 12:24:19');
INSERT INTO `document_uplode` VALUES (23, 18, 13, 99, 'png', 'Y', 4, '2023-06-19 12:24:20');
INSERT INTO `document_uplode` VALUES (24, 18, 15, 100, 'png', 'Y', 4, '2023-06-19 12:24:21');
INSERT INTO `document_uplode` VALUES (25, 18, 16, 101, 'png', 'Y', 4, '2023-06-19 12:24:22');
INSERT INTO `document_uplode` VALUES (26, 18, 11, 108, 'png', 'Y', 4, '2023-06-20 10:26:42');
INSERT INTO `document_uplode` VALUES (27, 18, 12, 109, 'png', 'Y', 4, '2023-06-20 10:26:42');
INSERT INTO `document_uplode` VALUES (28, 18, 13, 110, 'png', 'Y', 4, '2023-06-20 10:26:43');
INSERT INTO `document_uplode` VALUES (29, 18, 15, 111, 'png', 'Y', 4, '2023-06-20 10:26:44');
INSERT INTO `document_uplode` VALUES (30, 18, 16, 112, 'png', 'Y', 4, '2023-06-20 10:26:45');
INSERT INTO `document_uplode` VALUES (31, 18, 17, 113, 'png', 'Y', 4, '2023-06-20 10:26:45');
INSERT INTO `document_uplode` VALUES (32, 18, 18, 114, 'png', 'Y', 4, '2023-06-20 10:26:46');
INSERT INTO `document_uplode` VALUES (33, 18, 20, 115, 'png', 'Y', 4, '2023-06-20 10:26:46');
INSERT INTO `document_uplode` VALUES (34, 18, 11, 116, 'png', 'Y', 4, '2023-06-20 10:54:18');
INSERT INTO `document_uplode` VALUES (35, 18, 11, 117, 'png', 'Y', 4, '2023-06-20 11:03:11');
INSERT INTO `document_uplode` VALUES (36, 18, 11, 118, 'png', 'Y', 4, '2023-06-20 11:06:41');
INSERT INTO `document_uplode` VALUES (37, 18, 11, 119, 'png', 'Y', 4, '2023-06-20 11:09:05');
INSERT INTO `document_uplode` VALUES (38, 18, 11, 120, 'png', 'Y', 4, '2023-06-20 11:10:22');
INSERT INTO `document_uplode` VALUES (39, 18, 11, 121, 'png', 'Y', 4, '2023-06-20 11:11:23');
INSERT INTO `document_uplode` VALUES (40, 18, 11, 122, 'png', 'Y', 4, '2023-06-20 11:14:37');
INSERT INTO `document_uplode` VALUES (41, 18, 11, 123, 'png', 'Y', 4, '2023-06-20 11:28:59');
INSERT INTO `document_uplode` VALUES (42, 18, 11, 124, 'png', 'Y', 4, '2023-06-20 11:33:55');
INSERT INTO `document_uplode` VALUES (43, 18, 11, 125, 'png', 'Y', 4, '2023-06-20 11:38:48');
INSERT INTO `document_uplode` VALUES (44, 18, 11, 126, 'png', 'Y', 4, '2023-06-20 11:45:56');
INSERT INTO `document_uplode` VALUES (45, 18, 11, 127, 'png', 'Y', 4, '2023-06-20 11:50:38');
INSERT INTO `document_uplode` VALUES (46, 18, 12, 128, 'png', 'Y', 4, '2023-06-20 11:50:39');
INSERT INTO `document_uplode` VALUES (47, 18, 13, 129, 'png', 'Y', 4, '2023-06-20 11:50:39');
INSERT INTO `document_uplode` VALUES (48, 18, 15, 130, 'png', 'Y', 4, '2023-06-20 11:50:40');
INSERT INTO `document_uplode` VALUES (49, 18, 16, 131, 'png', 'Y', 4, '2023-06-20 11:50:41');
INSERT INTO `document_uplode` VALUES (50, 18, 17, 132, 'png', 'Y', 4, '2023-06-20 11:50:41');
INSERT INTO `document_uplode` VALUES (51, 18, 18, 133, 'png', 'Y', 4, '2023-06-20 11:50:42');
INSERT INTO `document_uplode` VALUES (52, 17, 11, 135, 'png', 'Y', 4, '2023-06-20 12:03:37');
INSERT INTO `document_uplode` VALUES (53, 17, 12, 136, 'png', 'Y', 4, '2023-06-20 12:03:38');
INSERT INTO `document_uplode` VALUES (54, 18, 11, 149, 'png', 'Y', 4, '2023-06-21 13:34:56');
INSERT INTO `document_uplode` VALUES (55, 18, 12, 150, 'png', 'Y', 4, '2023-06-21 13:34:57');
INSERT INTO `document_uplode` VALUES (56, 18, 13, 151, 'png', 'Y', 4, '2023-06-21 13:34:58');
INSERT INTO `document_uplode` VALUES (57, 18, 15, 152, 'png', 'Y', 4, '2023-06-21 13:34:58');
INSERT INTO `document_uplode` VALUES (58, 3, 13, 167, 'png', 'Y', 4, '2023-07-12 10:01:46');
INSERT INTO `document_uplode` VALUES (59, 3, 15, 168, 'png', 'Y', 4, '2023-07-12 10:01:48');

-- ----------------------------
-- Table structure for education_qualification
-- ----------------------------
DROP TABLE IF EXISTS `education_qualification`;
CREATE TABLE `education_qualification`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `education_qualification` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `value` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of education_qualification
-- ----------------------------

-- ----------------------------
-- Table structure for gold_details
-- ----------------------------
DROP TABLE IF EXISTS `gold_details`;
CREATE TABLE `gold_details`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `loan_id` bigint NOT NULL,
  `metal_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `item_remarks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_of_item` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gross_weight` double NOT NULL,
  `net_weight` double NOT NULL,
  `market_rate` float NOT NULL,
  `market_value` float NOT NULL,
  `lending_rate` float NOT NULL,
  `lending_value` float NOT NULL,
  `market_rate2` float NOT NULL COMMENT '=market_rate',
  `lending_rate2` float NULL DEFAULT NULL COMMENT '=lending_rate',
  `total_no_of_items` int NULL DEFAULT NULL COMMENT '=total no of item',
  `total_gross_weight` float NULL DEFAULT NULL COMMENT '=total gross weight',
  `total_net_weight` float NULL DEFAULT NULL COMMENT '=total weight',
  `total_market_value` float NULL DEFAULT NULL COMMENT '=market rate * total gross weight',
  `total_lending_value` float NULL DEFAULT NULL COMMENT '=lending rate * total weight',
  `apprisal_value` float NULL DEFAULT NULL COMMENT '=market rate * total weight',
  `total_sanction_amount` float NULL DEFAULT NULL COMMENT '= total lending value',
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` int NULL DEFAULT NULL,
  `updated_by` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of gold_details
-- ----------------------------
INSERT INTO `gold_details` VALUES (7, 7, '22 - Carat', 'Chain', 'test emarks', '20', 10, 5, 5648, 56480, 4500, 22500, 5648, 4500, 57, 30, 15, 169440, 67500, 84720, 4500, 'Y', 4, '2023-09-01 10:40:14', NULL, NULL);
INSERT INTO `gold_details` VALUES (8, 7, '22 - Carat', 'Ring', 'test emarks', '18', 9, 6, 5648, 50832, 4500, 27000, 5648, 4500, 57, 30, 15, 169440, 67500, 84720, 4500, 'Y', 4, '2023-09-01 10:40:14', NULL, NULL);
INSERT INTO `gold_details` VALUES (9, 7, '22 - Carat', 'earrings', 'test emarks', '19', 11, 4, 5648, 62128, 4500, 18000, 5648, 4500, 57, 30, 15, 169440, 67500, 84720, 4500, 'Y', 4, '2023-09-01 10:40:14', NULL, NULL);

-- ----------------------------
-- Table structure for golddetails
-- ----------------------------
DROP TABLE IF EXISTS `golddetails`;
CREATE TABLE `golddetails`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `marketvalue` int NOT NULL,
  `lendingvalue` int NOT NULL,
  `is_active` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of golddetails
-- ----------------------------
INSERT INTO `golddetails` VALUES (1, 5648, 4500, 'Y', '2023-08-31 11:11:49', 4, NULL, NULL);

-- ----------------------------
-- Table structure for golditems
-- ----------------------------
DROP TABLE IF EXISTS `golditems`;
CREATE TABLE `golditems`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of golditems
-- ----------------------------
INSERT INTO `golditems` VALUES (1, 'Chain', 'Y', '2023-08-31 11:21:17', 4, NULL, NULL);
INSERT INTO `golditems` VALUES (2, 'Ring', 'Y', '2023-08-31 11:21:23', 4, NULL, NULL);
INSERT INTO `golditems` VALUES (3, 'earrings', 'Y', '2023-08-31 11:21:58', 4, NULL, NULL);

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `show_on_menu` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `has_child` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `has_action_button` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (1, 'Dashboard', '<i class=\"fa fa-home sidemenu_icon text-dark\"></i>', 'dashboard', '1', 'N', 'N', 'Y', '2023-04-03 16:34:16', 1, NULL, 0);
INSERT INTO `groups` VALUES (2, 'Bank Profile', '<i class=\"fa fa-server sidemenu_icon text-dark\"></i>', 'bank_profile', '1', 'N', 'Y', 'Y', '2023-02-24 12:09:10', 1, NULL, 0);
INSERT INTO `groups` VALUES (3, 'Master Settings', '<i class=\"fa fa-cog sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-04-03 16:34:36', 1, NULL, 0);
INSERT INTO `groups` VALUES (4, 'User Logs', '<i class=\"fa fa-cogs sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-04-03 16:34:46', 1, NULL, 0);
INSERT INTO `groups` VALUES (5, 'Password Settings', '<i class=\"fa fa-unlock-alt sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-04-03 16:34:54', 1, NULL, 0);
INSERT INTO `groups` VALUES (6, 'Role & Permissions Master', '<i class=\"fa fa-users sidemenu_icon text-dark\"></i>', 'role_permission_master', '1', 'N', 'N', 'Y', '2023-04-03 16:35:04', 1, NULL, 0);
INSERT INTO `groups` VALUES (7, 'Product Managment', '<i class=\"fa fa-product-hunt sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-04-03 16:35:14', 1, NULL, 0);
INSERT INTO `groups` VALUES (8, 'User Managment', '<i class=\"fa fa-address-book sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'N', '2023-06-21 08:27:45', 1, NULL, 0);
INSERT INTO `groups` VALUES (9, 'Add Applications', '<i class=\"fa fa-address-book sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-05-23 07:19:39', 4, NULL, NULL);
INSERT INTO `groups` VALUES (10, 'Workflow & Version Control', '<i class=\"fa fa-code-fork sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-06-05 09:37:24', 4, NULL, NULL);
INSERT INTO `groups` VALUES (11, 'Loan', '<i class=\"fa fa-american-sign-language-interpreting sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-06-07 05:48:02', 4, NULL, NULL);
INSERT INTO `groups` VALUES (12, 'Report', '<i class=\"fa fa-file-text-o sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-06-07 05:48:02', 4, NULL, NULL);
INSERT INTO `groups` VALUES (13, 'API Logs', '<i class=\"fa fa-file-text-o sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-06-07 05:48:02', 4, NULL, NULL);
INSERT INTO `groups` VALUES (14, 'Quary Builder', '<i class=\"fa fa-building sidemenu_icon text-dark\"></i>', '#', '1', 'Y', 'N', 'Y', '2023-06-29 05:48:02', 4, NULL, NULL);

-- ----------------------------
-- Table structure for if_master
-- ----------------------------
DROP TABLE IF EXISTS `if_master`;
CREATE TABLE `if_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `if` varchar(10000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of if_master
-- ----------------------------
INSERT INTO `if_master` VALUES (1, 'loan pan length', 'strlen(loan_pan.value)', 'Y', '2023-08-16 18:11:50', 4, NULL, NULL);
INSERT INTO `if_master` VALUES (2, 'Loan amount value', 'loan_loan_amount.value', 'Y', '2023-08-16 18:12:14', 4, NULL, NULL);

-- ----------------------------
-- Table structure for kyc_sub_tab
-- ----------------------------
DROP TABLE IF EXISTS `kyc_sub_tab`;
CREATE TABLE `kyc_sub_tab`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kyc_tab_id` int NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `url` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `otp_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `dob_formate` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `header` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `cost` bigint NULL DEFAULT 0,
  `is_otp` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `is_status` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Y',
  `created_at` int NULL DEFAULT NULL,
  `created_by` datetime NULL DEFAULT current_timestamp,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 78 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kyc_sub_tab
-- ----------------------------
INSERT INTO `kyc_sub_tab` VALUES (24, 1, 'PAN Profile (Detailed)', NULL, NULL, 'https://testapi.karza.in/v3/pan-profile', NULL, NULL, '{\r\n  \"pan\": \"ABCDE6207P\",\r\n  \"lite\": \"Y\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', '{\r\n  \"pan\": \"D********F\",\r\n  \"aadhaarLastFour\": \"0908\",\r\n  \"dob\": \"YYYY-MM-DD\",\r\n  \"name\": \"Dhanashree Vinod Mirgal\",\r\n  \"address\": \"2/19 Kunti Devi Agarwal Nagar Caves Road Jogeshwari East Mumbai-400060\",\r\n  \"getContactDetails\": \"Y\",\r\n  \"PANStatus\": \"Y\",\r\n  \"isSalaried\": \"Y\",\r\n  \"isDirector\": \"Y\",\r\n  \"isSoleProp\": \"Y\",\r\n  \"consent\": \"Y\"\r\n}', 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (25, 1, 'ePAN Download', NULL, 'https://testapi.karza.in/v3/epan/otp', 'https://testapi.karza.in/v3/epan/validate', 'https://testapi.karza.in/v3/epan/status', '{\n  \"pan\": \"BXXXXXXXXR\",\n  \"aadhaarNo\": \"7XXXXXXXXXX8\",\n  \"dob\": \"19XX-01-2X\",\n  \"consent\": \"Y\"\n}', '{\n  \"requestId\": \"92201635-92c9-4c9b-9439-f21aeea1d7c2\",\n  \"otp\": \"490673\",\n  \"notifications\": {\n    \"webhook\": false,\n    \"webhookConfig\": {\n      \"url\": \"\",\n      \"headers\": {},\n      \"body\": {}\n    },\n    \"emails\": \"gulshan.r@karza.in\"\n  },\n  \"consent\": \"Y\"\n}', 'Y-m-d', '{\n  \"requestId\": \"057129fa-e570-4b82-a4d1-8d1edcc18e1d\"\n}', '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'Y', 'Y', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (26, 1, 'Aadhaar XML Download', NULL, 'https://testapi.karza.in/v3/aadhaar-xml/otp', 'https://testapi.karza.in/v3/aadhaar-xml/file', NULL, '{\r\n  \"aadhaarNo\": \"7**********8\",\r\n  \"consent\": \"Y\"\r\n}', '{\n  \"otp\": \"537984\",\n  \"aadhaarNo\": \"123412341234\",\n  \"shareCode\": \"5555\",\n  \"requestId\": \"93bccaf0-64ad-4584-9b54-c0c7c385bba1\",\n  \"consent\": \"Y\"\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (27, 1, 'E-Aadhaar Download (UIDAI-Based)', NULL, 'https://testapi.karza.in/v3/eaadhaar/otp', 'https://testapi.karza.in/v3/eaadhaar/file', NULL, '{\n  \"aadhaarNo\": \"7**********8\",\n  \"consent\": \"Y\"\n}', '{\n  \"otp\": \"772640\",\n  \"accessKey\": \"eb81bf52-ddb7-4802-a031-0982b6aba9cb\",\n  \"aadhaarNo\": \"799162930908\",\n  \"shareCode\": \"5555\",\n  \"consent\": \"Y\"\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (28, 1, 'Driver\'s License', NULL, NULL, 'https://testapi.karza.in/v3/dl', NULL, NULL, '{\n  \"dlNo\": \"MH0120130001960\",\n  \"dob\": \"DD MM YYYY\",\n  \"additionalDetails\": true,\n  \"consent\": \"Y\"\n}', 'd-m-Y', NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (29, 1, 'Voter ID (EPIC) ', NULL, NULL, 'https://testapi.karza.in/v2/voter', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"epic_no\": \"SXXXXXXXX8\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (30, 1, 'Passport', NULL, NULL, 'https://testapi.karza.in/v3/passport-verification', NULL, NULL, '{\r\n  \"consent\": \"y\",\r\n  \"fileNo\": \"BO3072344560818\",\r\n  \"dob\": \"17/08/1987\",\r\n  \"passportNo\": \"S3733862\",\r\n  \"doi\": \"14/05/2018\",\r\n  \"name\": \"OMKAR MILIND SHIRHATTI\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (31, 1, 'Ration Details', NULL, NULL, 'https://testapi.karza.in/v3/ration-details', NULL, NULL, '{\n  \"aadhaarNumber\": \"\",\n  \"rationCardNumber\": \"12344556433\",\n  \"consent\": \"Y\"\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (32, 1, 'KRA KYC Status', NULL, NULL, 'https://testapi.karza.in/v3/kra-status', NULL, NULL, '{\r\n  \"pan\": \"CXXXXXXXXP\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (33, 2, 'Entity PAN Profile', NULL, NULL, 'https://testapi.karza.in/v3/pan-aadhaar-profile', NULL, NULL, '{\r\n  \"clientData\": {\r\n    \"caseId\": \"123456\"\r\n  },\r\n  \"pan\": \"ABCDE1234F\",\r\n  \"monthYearOfBirth\": \"02-1990\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (34, 2, 'GST Search Basis PAN', NULL, NULL, 'https://api.karza.in/gst/uat/v2/search', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"pan\": \"AAACR5055K\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (35, 2, 'GSP GST Authentication', NULL, NULL, 'https://api.karza.in/gst/uat/v2/gst-verification', NULL, NULL, '{\r\n  \"clientData\": {\r\n    \"caseId\": \"123456\"\r\n  },\r\n  \"pan\": \"ABCDE1234F\",\r\n  \"monthYearOfBirth\": \"02-1990\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (36, 2, 'GSP GST Return Filing', NULL, NULL, 'https://api.karza.in/gst/uat/v2/gst-return-status', NULL, NULL, '{\r\n  \"gstin\": \"27AEQPC4716B1ZS\",\r\n  \"consent\": \"Y\",\r\n  \"liabilityDetails\": false,\r\n  \"dueInfo\": true\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (37, 2, 'GST Authentication', NULL, NULL, 'https://api.karza.in/gst/uat/v2/gstdetailed', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"additionalData\": false,\r\n  \"gstin\": \"27AAACR5055K1Z7\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (38, 2, 'GST Advanced', NULL, NULL, 'https://api.karza.in/gst/uat/v2/gst-advanced', NULL, NULL, '{\r\n  \"pan\": \"AAECP3450G\",\r\n  \"consent\": \"Y\",\r\n  \"liabilityDetails\": \"<<true/false>>\",\r\n  \"stateCode\": [\r\n    \"29\",\r\n    \"19\",\r\n    \"33\"\r\n  ]\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (39, 2, 'FSSAI License Authentication', NULL, NULL, 'https://testapi.karza.in/v2/fssai', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"reg_no\": \"10013022002245\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (40, 2, 'MCA Signatories', NULL, NULL, 'https://testapi.karza.in/v2/mca-signatories', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"cin\": \"AAA-1234\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (41, 2, 'Udyog Aadhar Number', NULL, NULL, 'https://testapi.karza.in/v2/uam', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"uan\": \"GJ20A0007692\",\r\n  \"mobile\": \"\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (42, 2, 'TNA Authentication', NULL, NULL, 'https://testapi.karza.in/v2/tan', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"tan\": \"HYDD00592E\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (43, 2, 'IEC Detailed Profile', NULL, NULL, 'https://testapi.karza.in/v2/iecdetailed', NULL, NULL, '{\r\n  \"iec\": \"0388066415\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (44, 2, 'Legal Entity Identifier (LEI)', NULL, NULL, 'https://testapi.karza.in/v3/lei', NULL, NULL, '{\r\n  \"leiNo\": \"3358008J1F38JKKWXK61\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (45, 2, 'Udyam Registration Check', NULL, NULL, 'https://testapi.karza.in/v3/udyam/auth', NULL, NULL, '{\r\n  \"consent\": \"Y\",\r\n  \"udyamRegistrationNo\": \"UDYAM-MP-23-0007772\",\r\n  \"isPDFRequired\": \"Y\",\r\n  \"getEnterpriseDetails\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (46, 2, 'Udyam Registration Check (OTP Based)', NULL, 'https://testapi.karza.in/v3/udyam/otp', 'https://testapi.karza.in/v3/udyam/verify', NULL, '{\r\n  \"consent\": \"Y\",\r\n  \"udyamRegistrationNo\": \"UDYAM-MP-23-0007772\",\r\n  \"mobile\": \"8********9\",\r\n  \"isPDFRequired\": \"Y\",\r\n  \"getEnterpriseDetails\": \"Y\"\r\n}', '{\r\n  \"requestId\": \"568795af-6697-473f-95f7-cde50bb23c4b\",\r\n  \"otp\": \"186282\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (47, 2, 'VAT TIN Verification', NULL, NULL, 'https://testapi.karza.in/v2/tin', NULL, NULL, '{\r\n  \"tin\": \"27290171042\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (48, 3, 'CA Membership Authentication', NULL, NULL, 'https://testapi.karza.in/v2/icai', NULL, NULL, '{\r\n  \"membership_no\": \"235400\",\r\n  \"contactDetails\": true,\r\n  \"consent\": \"y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (49, 3, 'ICSI Membership', NULL, NULL, 'https://testapi.karza.in/v3/icsi', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"membershipNo\": \"A4567\",\r\n  \"cpNo\": \"\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (50, 3, 'ICWAI Firm Authentication', NULL, NULL, 'https://testapi.karza.in/v2/icwaif', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"membership_no\": \"14530\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (51, 3, 'NMC Membership ', NULL, NULL, 'https://testapi.karza.in/v3/nmc', NULL, NULL, 'https://testapi.karza.in/v3/nmc', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (52, 3, 'UDIN Verification', NULL, 'https://testapi.karza.in/v3/udin/otp', 'https://testapi.karza.in/v3/udin/verify', NULL, '{\r\n  \"consent\": \"Y\",\r\n  \"udin\": \"19xx1270xxxxxx5091\",\r\n  \"mobile\": \"9436xxxx62\"\r\n}', '{\r\n  \"consent\": \"Y\",\r\n  \"requestId\": \"0182ca74-xxxx-xxxx-848c-aa3c4078d796\",\r\n  \"otp\": \"12345\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (53, 4, 'PNG Authentication', NULL, NULL, 'https://testapi.karza.in/v2/png', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"consumer_id\": \"1000082138\",\r\n  \"bp_no\": \"\",\r\n  \"service_provider\": \"AG\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (54, 4, 'Electricity Bill Authentication', NULL, NULL, 'https://testapi.karza.in/v2/elec', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"consumer_id\": \"1012395000\",\r\n  \"service_provider\": \"BESCOM\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (55, 4, 'LPG ID Authentication', NULL, NULL, 'https://testapi.karza.in/v2/lpg', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"lpg_id\": \"10000000050431060\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (56, 4, 'LPG ID Authentication', NULL, NULL, 'https://testapi.karza.in/v2/lpg', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"lpg_id\": \"10000000050431060\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (57, 4, 'Mobile Authentication', NULL, NULL, 'https://testapi.karza.in/v3/mobile-auth', NULL, NULL, '{\r\n  \"countryCode\": \"91\",\r\n  \"mobile\": \"9819574650\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (58, 4, 'Mobile Authentication with OTP', NULL, 'https://testapi.karza.in/v2/mobile/otp', 'https://testapi.karza.in/v2/mobile/status', 'https://testapi.karza.in/v2/mobile/details	', '{\r\n  \"mobile\": \"\",\r\n  \"consent\": \"y\"\r\n}', '{\r\n  \"request_id\": \"60a74ccf-9206-4ff7-89fb-433c8bd2be37\",\r\n  \"otp\": \"004389\"\r\n}', NULL, '{\r\n  \"request_id\": \"60a74ccf-9206-4ff7-89fb-433c8bd2be37\"\r\n}', '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'Y', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (59, 4, 'Telephone Landline Authentication', NULL, NULL, 'https://testapi.karza.in/v2/tele', NULL, NULL, '{\r\n  \"tel_no\": \"022-21730600\",\r\n  \"city\": \"Mumbai\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (60, 5, 'EPF Authentication', NULL, 'https://testapi.karza.in/v2/epf-get-otp', 'https://testapi.karza.in/v2/epf-get-passbook', NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"uan\": \"\",\r\n  \"mobile_no\": \"9xxxxxxxx2\"\r\n}', '{\r\n  \"request_id\": \"2badb5d1-f52c-11e7-9f18-bfdb0730e539\",\r\n  \"otp\": \"480085\",\r\n  \"is_pdf_required\": \"y\",\r\n  \"partial_data\": \"n\",\r\n  \"epf_balance\": \"y\"\r\n}', NULL, NULL, NULL, NULL, 0, 'Y', 'N', 'Y', NULL, '2023-06-16 13:22:04', '2023-06-16 09:50:26', NULL);
INSERT INTO `kyc_sub_tab` VALUES (61, 5, 'EPF UAN Lookup', NULL, NULL, 'https://testapi.karza.in/v2/uan-lookup', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"mobile\": \"9619202624\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', '{\r\n  \"pan\": \"D********F\",\r\n  \"aadhaarLastFour\": \"0908\",\r\n  \"dob\": \"YYYY-MM-DD\",\r\n  \"name\": \"Dhanashree Vinod Mirgal\",\r\n  \"address\": \"2/19 Kunti Devi Agarwal Nagar Caves Road Jogeshwari East Mumbai-400060\",\r\n  \"getContactDetails\": \"Y\",\r\n  \"PANStatus\": \"Y\",\r\n  \"isSalaried\": \"Y\",\r\n  \"isDirector\": \"Y\",\r\n  \"isSoleProp\": \"Y\",\r\n  \"consent\": \"Y\"\r\n}', 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (62, 5, 'Employment Verification Advanced', NULL, NULL, 'https://testapi.karza.in/v2/employment-verification-advanced', NULL, NULL, '{\r\n  \"uans\": [\r\n    \"100414119974\"\r\n  ],\r\n  \"entityId\": \"U74120MH2015PTC265316\",\r\n  \"employerName\": \"Karza Technologies Private Limited\",\r\n  \"employeeName\": \"Swarnava Maitra\",\r\n  \"mobile\": \"8450939766\",\r\n  \"emailId\": \"swarnava.m@karza.in\",\r\n  \"pdf\": true\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', '', 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (63, 5, 'Employer Default Check', NULL, NULL, 'https://testapi.kscan.in/v3/epf-compliance', NULL, NULL, '{\r\n  \"cinKid\": \"MHBAN1744410000\",\r\n  \"fromDate\": \"11-2019\",\r\n  \"toDate\": \"04-2020\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', '', 5, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (64, 5, 'Form 16 Authentication', NULL, NULL, 'https://testapi.karza.in/v2/tds', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"tan\": \"DELE06823F\",\r\n  \"pan\": \"BXXXXXXXXR\",\r\n  \"cert_no\": \"MICQCLI\",\r\n  \"amount\": \"152609\",\r\n  \"fiscal_year\": \"2014-15\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (65, 5, 'Form 16 Quarterly\r\n', NULL, NULL, 'https://testapi.karza.in/v3/tdsq', NULL, NULL, '{\r\n  \"entityId\": \"U74999MH2005PTC150644\",\r\n  \"tan\": \"MUMY01286F\",\r\n  \"pan\": \"BXIPR3831G\",\r\n  \"fiscalYear\": \"2020-21\",\r\n  \"quarter\": 1,\r\n  \"employmentType\": \"SALARY\",\r\n  \"consent\": \"y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (66, 5, 'ITR-V Authentication', NULL, NULL, 'https://testapi.karza.in/v2/itr', NULL, NULL, '{\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"ack\": \"149632760130721\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (67, 5, 'Income Tax Challan Authentication', NULL, NULL, 'https://testapi.karza.in/v2/tds/challan-auth', NULL, NULL, '{\r\n  \"bsrCode\": \"0014431\",\r\n  \"challanSerialNo\": \"03924\",\r\n  \"amount\": \"16000\",\r\n  \"date\": \"17/08/2018\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (68, 5, 'State Employee Search', NULL, NULL, 'https://testapi.karza.in/v3/state-employee-search', NULL, NULL, '{\r\n  \"stateCode\": \"AS\",\r\n  \"parentDepartment\": \"Assam Assembly\",\r\n  \"employeeName\": \"\",\r\n  \"employeeCode\": \"10232\",\r\n  \"consent\": \"Y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (69, 10, 'Property Tax', NULL, NULL, 'https://testapi.karza.in/v3/property-tax', NULL, NULL, '{\r\n  \"state\": \"MAHARASHTRA\",\r\n  \"city\": \"GREATER MUMBAI\",\r\n  \"propertyNo\": \"NX1007310370001\",\r\n  \"district\": \"\",\r\n  \"ulb\": \"\",\r\n  \"consent\": \"y\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (70, 10, 'Vehicle RC Authentication - Advanced', NULL, NULL, 'https://testapi.karza.in/v3/rc-advanced	', NULL, NULL, '{\r\n  \"registrationNumber\": \"MH04CY4545\",\r\n  \"consent\": \"<<Y/N>>\",\r\n  \"version\": 3.1\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (71, 11, 'Bank AC Verification', NULL, NULL, 'https://testapi.karza.in/v2/bankacc', NULL, NULL, '{\r\n  \"consent\": \"Y\",\r\n  \"ifsc\": \"\",\r\n  \"accountNumber\": \"\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (72, 11, 'UPI Verification', NULL, NULL, 'https://testapi.karza.in/v2/upi-verification', NULL, NULL, '{\r\n  \"name\": \"sushant yadav\",\r\n  \"vpa\": \"sushant.0501@okicici\",\r\n  \"consent\": \"Y\",\r\n  \"nameMatchType\": \"\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (73, 12, 'Email Authentication', NULL, NULL, 'https://testapi.karza.in/v2/email', NULL, NULL, '{\r\n  \"email\": \"omkar@karza.in\",\r\n  \"version\": \"<<2/2.1/3.2>>\"\r\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (74, 13, 'Address Matching', NULL, NULL, 'https://testapi.karza.in/v3/address', NULL, NULL, '{\n  \"address1\": \"SR NO-52,ROAD NO-3 NR DATA MANDIR  411015\",\n  \"address2\": \"ROAD NO-3, SR NO-52 411015\"\n}', NULL, NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);
INSERT INTO `kyc_sub_tab` VALUES (77, 15, 'AML Sanctions Screening', NULL, NULL, 'https://testapi.kscan.in/v3.2/search/aml', NULL, NULL, '{\r\n  \"name\": \"\",\r\n  \"dateOfBirth\": \"05/01/2002\",\r\n  \"gender\": \"MALE, FEMALE\",\r\n  \"agency\": \"\",\r\n  \"pdfReport\": false,\r\n  \"nameMatch\": false,\r\n  \"nameMatchThreshold\": false\r\n}', 'd/m/Y', NULL, '{\"Content-Type\" : \"application/json\",\r\n\"x-karza-key\": \"<<YOUR KEY HERE>>\"}', NULL, 0, 'N', 'N', 'Y', 1, '2023-05-15 17:48:43', '2023-05-15 14:17:14', NULL);

-- ----------------------------
-- Table structure for kyc_tab
-- ----------------------------
DROP TABLE IF EXISTS `kyc_tab`;
CREATE TABLE `kyc_tab`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Y',
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kyc_tab
-- ----------------------------
INSERT INTO `kyc_tab` VALUES (1, 'KYC Retail', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (2, 'KYC Commercial', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (3, 'KYC Professionals', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (4, 'Utility Bills', NULL, 'Y', '2023-05-15 17:44:52', 1, '2023-05-15 14:13:49', NULL);
INSERT INTO `kyc_tab` VALUES (5, 'Employment & Salary', NULL, 'Y', '2023-05-15 17:44:52', 1, '2023-05-15 14:13:49', NULL);
INSERT INTO `kyc_tab` VALUES (6, 'Matching Utilities', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (7, 'Asset Authentication', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (10, 'Asset & Vehicle Authentication', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (11, 'Banking & Payments Authentication', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (12, 'Digital Essentials –Contactability', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (13, 'Digital Essentials – Matching& Similar', NULL, 'Y', '2023-05-15 17:43:25', 1, '2023-05-15 14:11:55', NULL);
INSERT INTO `kyc_tab` VALUES (15, 'Miscellaneous', '#', 'Y', '2023-06-22 05:30:26', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for loan_approve
-- ----------------------------
DROP TABLE IF EXISTS `loan_approve`;
CREATE TABLE `loan_approve`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `loan_id` bigint NOT NULL,
  `role_id` bigint NULL DEFAULT NULL,
  `user_id` bigint NOT NULL,
  `version_id` bigint NOT NULL,
  `comments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('A','R','P') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'A=Approve, R=Reject, P=Pending',
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Y=Yes, N=No',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_approve
-- ----------------------------
INSERT INTO `loan_approve` VALUES (32, 79, 12, 18, 14, 'approve by renuka k cleark', 'A', 'Y', '2023-06-21 13:47:56', 18, NULL, NULL);
INSERT INTO `loan_approve` VALUES (33, 80, 12, 18, 14, 'Approved', 'A', 'Y', '2023-06-21 21:18:25', 18, NULL, NULL);
INSERT INTO `loan_approve` VALUES (34, 80, 12, 19, 14, 'Please city name', 'R', 'Y', '2023-06-21 21:20:51', 19, NULL, NULL);

-- ----------------------------
-- Table structure for loan_form_data
-- ----------------------------
DROP TABLE IF EXISTS `loan_form_data`;
CREATE TABLE `loan_form_data`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `branch` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `product_type` int NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `loan_test_pincode` int NULL DEFAULT NULL,
  `loan_village` enum('') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '=',
  `loan_eligibility_per` int NULL DEFAULT NULL,
  `loan_salary` int NULL DEFAULT NULL,
  `loan_eligibility_amount` int NULL DEFAULT NULL,
  `loan_loan_amount` int NULL DEFAULT NULL,
  `loan_aadhar_number` int NULL DEFAULT NULL,
  `loan_total_income` int NULL DEFAULT NULL,
  `loan_other_income` int NULL DEFAULT NULL,
  `loan_gross_income` int NULL DEFAULT NULL,
  `loan_gold_type` enum('21') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '21=21 - Carat',
  `loan_pan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `loan_district` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `loan_city` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `loan_address_line_1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `loan_phone_number` int NULL DEFAULT NULL,
  `loan_email_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `loan_marital_status` enum('Single','Married','Divorced','Widow') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Single=Single,Married=Married,Divorced=Divorced,Widow=Widow',
  `loan_age` int NULL DEFAULT NULL,
  `loan_date_of_birth` date NULL DEFAULT NULL,
  `loan_gender` enum('M','F') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'M=Male,F=Female',
  `loan_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `verify_statas` enum('P','A','R') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'P' COMMENT '	P = \'Pending\', A = \'Approved\', R = \'Rejected\'	',
  `verify_by` int NULL DEFAULT NULL,
  `version_id` bigint NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_form_data
-- ----------------------------
INSERT INTO `loan_form_data` VALUES (1, 3, '0', 11, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1a0a0f55c07a5ed375100f78f58c3ba8c0373b23487d75ece13e990ebd11f079f036cc42e3478394ef62bf70e931d999a35cdee198e0058284210161d5990e55yUe9wd/vINGrvpvh2wGQ8K0Y8+jdsj4HixwGXePfyP8=', '893a553bfeecd03558cb753670a1dc3edf22fe2395426e872c54ff5c8173f8c4ba6381e0373b93dfc0152990a041d3523dc4cd17bab631646cc79e361811451e93vFKj5p1Wnr9fsbjEMHOLwhCebYlJFWWd6VRMh7a5vH/Fz1xVsaVTO6OS6N0h6O', NULL, '94f98ae5b1c130b91d8f09a1c58eaee5a155463df76363963cb29b0451a319284f7f30051eefe672d5ee955a09c1c70f1f9c6ebd33b956c439e91b81e94e5a7fIv3+c96nRAA73NjWS8XRybDHESR++CKUdumeSLdVy+jAlKbn6o4+z/1ysHsq9M9R', 2147483647, 'Suhrid Sarkar || suhrid.developer@gmail.combasak97@gmail.com', 'Single', 26, '1997-03-14', 'M', '5d59121f4ec48258e1da1a67c0b4f7f5faf5094202180c437bbcfd34669b9b14c371763db066633501de5a9180723975ae0bd442b7ee1185d9d69392844cd9b60Dbtwi9ulyEke1aO04vwN0iryU1lp8j1xerXcUKDb0w=', 'P', NULL, 17, 'Y', '2023-07-12 10:01:42', 4, NULL, NULL);

-- ----------------------------
-- Table structure for loan_input_master
-- ----------------------------
DROP TABLE IF EXISTS `loan_input_master`;
CREATE TABLE `loan_input_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `loan_tap_master` int NULL DEFAULT NULL,
  `loan_panel_master` int NULL DEFAULT NULL,
  `field_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_name_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `master_or_value` enum('M','V') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `master` int NULL DEFAULT NULL,
  `is_required` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_autofetch` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `auto_fetch_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_input_master
-- ----------------------------
INSERT INTO `loan_input_master` VALUES (1, 1, NULL, 'fe681013f73df6f5fdfe7449544d7898f191a21ea91c249ac9cadd2453475ba850d535f076b378fd78c32e3f3a427bca8a64b354882e5367fd8ada03da62cc02WmiSfbMtTm28mGKWSW04ar6iaqDxkllNOFFLC3LRy0A=', 'bbfa38e45a5c140be3e10dac2e51ad3ce82d374c7c77d0b42eccf914ce458c530cd964ddb5a74838896d00efe007de4a5abcb73c42001eb04a2221ce878d00edB9VfpeHZjVv0XaQg+Jt0kV6Cu6H8HzF23YUVZ+jZlmU=', '698aea07782315ed305aaabda2b1b931c6bfe937378c8e5ed880b03f56cad66e3ad56dabb5a13fe73529e3eac245e362af0681eb4ba23e11f8d502fa9797b8d0PlGpt3udBiZcEUG4i6wVwdis22qE8HQ3AmAxHL0lkvg=', 'M', 0, 'Y', '2023-05-18 17:44:05', 4, '2023-05-18 17:44:05', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (2, 5, NULL, 'e13f8479edaa411e345909d2aae80232bf7ca546fd9863503d77167ea2bac36fb7ccf2219f30a9d13351eaad7aac3a37fb8d6b0c5ecac5c879adac91f06b3b55NEAtwlAWcGgL+P10DJtzuQaSg75uVBdMxRbBfUY597U=', '6f8066eaa77509dc0e37ac5b86bd22b3a0bb91bfcdbc289b49e4e00c54b6d2c05c2260ab03e006d137aba2e93fdc7257bd7010d99e61b2e1f15d218e4592042573FjdKSgIBWKOECRER5N0sO+6JPC0b+bP+2Pz6H7pi8=', 'fcf9d2bebf4e158fb40715b23a2c2786a7f179046f8c36009681f55466a913780688b0fb985b151c7b33c4f2abf5ff012aab0923f670326e7698e422a0d5427efFTFf985buGxIrpwR568jfWpvoI+PbojuThT3ZTQa+I=', 'M', 21, 'Y', '2023-05-18 17:44:50', 4, '2023-05-18 17:44:50', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (3, 4, NULL, '1b4c633cfe145b2535d3eb10ebd0e3fa4979e226565f02fc6ae23fc350402af7d4d8310efda03f3fd2f884535ea69e986318ada680608dea587dc7a7551ec5c4Gkn+6hq8BBmv1PVHyYdWfMhFe7Od1Y4EFkwQCC+29+s=', '66eb7251f92715769cd8b7979f74ccb3693c8ea4d59fee02960d04e64265374c4c9c8521fdc352b7ae52201dc1a78cfe862ed3a8a8ba39a375b8741a0fd7b274kdtF1kTHTJdFjsO7JkJCgHfY6e5PCUjjbeMhY+y3LVU=', '67e4930798cc690d9d270d5fefff01bcd7a2f0373ef5dc56017084a73fc86d441dc16621b20607f1142e604c8ccc4c56d11bf9e113339a98b536e183702e7be6tBOfbSsLEfOcppk6tIEKkc94USih6i90ojeKP97tCiU=', 'V', NULL, 'N', '2023-05-18 17:46:06', 4, '2023-05-18 17:46:06', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (4, 1, 3, '354a9703b96ea0095bc2f9a6875a28d48fc1ce51553c31fc9f67332fb16fe1c6eba8619450fc40027382162aabb08df1d699316c417c5b89ef8782896f2559911m2DaE0ni+Vav0pK5OJO7p0AR2lgoZv8AJHCDTjznno=', '49c945bf9cf4c98b1c0067f9c55751077134a873985a0ec11f1193186c63927a3aa14598928ecbfa34236dcfa91c1d413c66c7dd8229a9f1de7d704875c580beQJOKUgtDY8+fiMrn/V8bIztLozr/o8y99EFjqKSLMdw=', '5934130263579c1bd13a597797720bd431674845fae154c12c667f4a577e3d610260ad7603de6ba41d941a253bcc7ee10ba586392cd6c556855780284b94bc4bJeekrKM/okgU/WtpA0kxL36JlIM46epyDjzbjvvwOiI=', NULL, NULL, 'N', '2023-05-18 17:46:57', 4, '2023-05-18 17:46:57', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (5, 1, 1, 'a29c3f90c11013d97d78d687f15530be1863e74e91de827c7ebb66533ec498dbb84e30722747b135e1bd7ec231e0af0ad0d5656b1623d9539b8eece0e0202f299w+4eeQCG+DoSETfpZSXfBYmWJRCrPv+5Gl8Qm8eSV8=', 'a2e9ca6f368afd81bfe88edc5c8ed34f381769ea08d272cfc12cea554bd1c5709d129ad382e11b103c0a1cc41d3f057bf2ef18520cf2b5de2bfa74692d5a3a85KR91Ap7ILviQUxcmZDTituFJVFl70gk7X8ohKKJ8R40=', '3ecf91430345b6a551b63c6be16711694bcb8e39a1244a3f59f9e6e40c92a55a66d4a0a441d6502355a31e7409d0c09bef91f5a189a9b5122812658f6019acf1jdtPgKh4VVvdnZtiwvRApm9SyzOIFQLPTAC9OS44/4w=', NULL, NULL, 'N', '2023-05-18 19:18:43', 4, '2023-05-18 19:18:43', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (6, 1, 1, 'eaa691a3d38d36c759f575f9e31dc73b32d4f8d0a41ae162c20f15c28a4127fca099c3f2766187d845e3e01089130fea9893f6cac666a8d7566d7db1c7578481LIspHun+lSz6d8ydoxQ/R4jzFsoxCU9S+A0Axzi7RX4=', 'c1941819531ff8167017c812c217462d4305c81a7c7e8f0ca564a3a407662ea7d66004492ffc52fccf1ffa833b3612bef2653c58c7d97eea1519d6ee06d0b54bOG3bOZuPub3iVkQ43TcJBApPjuUUqTR3E0LROAM8oM0=', '856c96fc3fa4339733838c51d76abc3cdc93d8102f48836f08779549d0539ed72b7598b7790e7157eb356e2f9df6de94ecc1e1385eacfbdfa7cc2c5c892e9ea4tVHukDRCP/1YRezkKfsZb7CY43j0weu2OehmtT9oF84=', NULL, NULL, 'Y', '2023-05-18 19:19:34', 4, '2023-05-18 19:19:34', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (7, 1, 2, '056e193f24dd43b81f28e073a673bdb58e8226387a33c7036f5f4b0e0234aad0be42be3bb2f84c8856a7d0aebe893dc700d210e84c9225db5baf8fc0f29b4041o2c00pD/3sdWRQDpnJXZJclGtMiIJkzY2uLxsWL487g=', 'da98c813514b4f83c1086fc5c0621dbbd8465a55abe2e14dd6a704673b155f61d37ab5c2a06eadfb97a38b8e25342a74cea7e10cfa7173704853e053f0396bd2337OhpBswjHHSOkxOUGu/AQZAS45v1XeoAD7R+13mS8=', 'a9d08b1853e5074b3fb4c5905b6728bc9127217bb9342a5c03ce6e67e576bb0e5658cba9d5882cdebf268697b972fc607cdabe7f1c5b804acc095861de8c31f3nM7XTRJMl8DN2P4APKU8ctHY6T+A45LPezMG451Gess=', NULL, NULL, 'N', '2023-05-18 19:19:53', 4, '2023-05-18 19:19:53', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (8, 1, 2, 'efd72cb03d037f409eafdf5caa66721808174734cac4545feb3d709fd5991e7627bbf2527e291be4af79cf76ad5f818e1efbc601f9c35462322f445356824bbfBK154ctLnvoxatEewDowUjeKiX14lSO5CZ+DZP+9bKM=', '2e76546f66c118d96c8788e440de264cc4c1fbeb90665172c74ef521ae759fa9c5e58827e4586d187eef018607de6c4b458b07f7e7263eb11a6f79b049990711fkpxeKeoTuNju/QDEpB5lY3y2fHCQltzqO9YD25EsIs=', '16c96d48d9977062ae68e0c964ae25e56fd0fe7481ed318d2b4a576eb73e83bdb33bcc1833082f93e8bfae9faecc06509e5deacfbdcff205a04a658d7abb011fCROVhA2doRAXU46YCPxzvL+EEoOYv+PdCvp/XQx5iX4=', NULL, NULL, 'N', '2023-05-19 09:49:19', 4, '2023-05-19 09:49:19', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (9, 1, 10, 'b8d487681894da856674a14ee73eb0174e45b1b4b3950f4c2dc5e26a9fc03c1b86645e68347493a6a7701e3b9d2ec08d2e1d9c350105d249420c9fc85176a4cdVfr4THG4kSdFFn45xU+QVp2iWvCDo/UX5lGb+N+uY1o=', 'ff53e197f08a09255e196d36d7fee29bcf5ba96a9de348d7784081a9d63db70982d5fe05c3b9de9d635b372404e9e6b4a4d53f6d2d97c6b226b542b75c7ceb02WcQ9LgGUXHZmGtJagkiAJEBw8OtLUX8xCPOwKMo3oAA=', '26da3567dc2065e4d2390ee55bd8742ff3298cfda85937741a6aa328f2fe7d0d3e1948f56b6b4a5cda30acc22047df49ce8e9371a5b7ebd29737ebe2fe49db3dYWgeOAtilwxBfMVnDPafciE+z36aEdjN3e8WgevC0BA=', NULL, NULL, 'Y', '2023-05-19 09:50:01', 4, '2023-05-19 09:50:01', NULL, 'Y', 'Y', 'name');
INSERT INTO `loan_input_master` VALUES (10, 1, 10, '6b14ea19fa0e7d7e3fbc013ce305c3d16dd54821b59007660562fcfca08fd0dadb197ca8ddb17055c8db3d506abe6e89f8ce7bd97982596593eb5e8ad03aa0d0KtdLUcQG8ekVDuwVbMyADKusK+C7eB47JNiEfoCRt+g=', '216ff50be82ca1c636050f25c59a4d21af18a26fe2da6d52191e0c5a42313c523754c237c7513bff41de10978186e87b1ec37cd655db22bdedf775ba9346d096ztbuF5iUsWbNFOJZjg1jsXnfwNMKwh65MwZDnm5scEA=', '0ff6ff58f363c93472b41a7291084973e7b7bbe9506c4fb611bf89dfd3e17548450413b1579d584e236fd0fd6f699e668149245ab11bc8a75bc959df2ffc64cc1RTa/JxretByUCpAKVU7VbG09lZSeHH1Wi2sW3qfRPQ=', 'V', NULL, 'N', '2023-05-19 09:53:54', 4, '2023-05-19 09:53:54', NULL, 'Y', 'Y', 'gender');
INSERT INTO `loan_input_master` VALUES (11, 1, 10, 'd96188dfea04d38c8aa955a905c4e410ff8d31608f9b000723526cb6d940e61a3a946ee6ee25f08a4cbb7c843a5170be0dea93cd23d440878f8bc75848fe26c13JKs/AiFdyVZ9s9bAlhWWSv6Gpzk8i6h+5IhvOLkp9g=', '51e3de111410732f4ab0bfa0c39f599438d2c91e0f52db03ef87eb01d5f6a751f55ce79ad3316620b81415db2cc58db7eabefd0c7d9cb6534a01451e91ab31442Z+mUbZHFchtMJQjqXmQ2XcfpjKgvyBQ732FuPfKytc6TEY9cjPJ6nSMj5bCMQxH', '1b28d0a70eafa26ce2c9b450035194c7ba6a691bf6c211fc1d07653062d0cf6e71169de85e2a3ce7ab049607fe2a6a655f2728a6d713da38371c7757dc40174bX6papYiKzwwTbCQRTxxyYxqEZpGGGkO9TwCR/LxRrzg=', NULL, NULL, 'Y', '2023-05-19 09:54:22', 4, '2023-05-19 09:54:22', NULL, 'Y', 'Y', 'dob');
INSERT INTO `loan_input_master` VALUES (12, 1, 10, '4c1f3b4cf5f15b040eb5c4a4508e43c4719169f4c0aa0c6c784e71802796bdfd8b3f34a1fadec186ecb50c1703e405fa1ddf883b150d9be8d1ee0fb220c76cb2qHzMLhfhIPxyF+rKqnicpGiWcKg8GUOg9aF/Td4c8Q8=', '039c3b24c6cde3ad5c2a5a5067f1fdccd7951a81bdbc977b60a2e6f51e1d7386b332aaa1a20d95e7678e9480659211de187f1f63e19f872e34930ca44b30072byeF/2Yn+LHXiplbiJ2fifEIpbuh5+6kYZW8pUcG2Ag0=', '75572c67bbc02acf25c766156d43a9a319c89a90c9c7d78a55625d5cf3e7750e8632a435a8dac9523614a1dd58aefd63aa57d7554f22285eb28661e30f2919c1IUd4rWZ6lxcspxD5KvrP9MUr0JycZgm2wwIf5QyDA9M=', NULL, NULL, 'N', '2023-05-19 09:54:43', 4, '2023-05-19 09:54:43', NULL, 'Y', 'Y', 'age');
INSERT INTO `loan_input_master` VALUES (13, 1, 10, '7499e948ef5086c48eaa92d6a28efea8e09c72e57edfae632f782cd96bb448c7068e620c78ad2fc924dace0b2e401972e8b744c4085958dc5bc955b821fcffeffqJDJfsywgZaSbxCE7vAimUyihHpmBN6KrSruLO09Jw=', '9d1463de107fa78c1f08e081168935ba393a506ab34f2b49c06b810851f504160a4309268d299e898fa6340576c73e6cd6ae95ebefda022b15fccc3b47e385a0yeNueRFEAUqKom4K/Dv971l5HpogUiOwvDmBIMG0xTJlexgAVvx4ApUvyabFweoJ', '31dae401c61db8c5687cce7d926eb9492f91a50d1ef1a1a641cd697dd3c55589bcb9a6c888ecfc0b77761add7f071b881c0b92973c3c964b18b9dca55f3d1580SU7ALC8nA8VkoflHfq1x8Jne4nFwn+ZyNvt0pUj/3UE=', 'V', NULL, 'Y', '2023-05-19 09:56:10', 4, '2023-05-19 09:56:10', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (14, 1, 10, '8b9b503a938c738ec957fd31d522b84c1d3eff0498f2bf31be4e9e562d924b2245a71cc62187fb536576c49f673f4e559bf2db9989d3177aeda0db54f35a0d28DEff2u3DZtnAXWqQItwlgx3FMiUzsLJwnnBXfM36Lwc=', '1538a3feb79f62951b80be72fabd8909b8b00795da65b25668be547bbca0a7466377d86edb5a587bf5926a72639d6b15252a935d8598c1f30d8a8256d42f575beIupRTrFn7oCpJx34Ct8/m4i/spMCXx1+r7LPwZwojw=', '7788899025aae67c17c19bf35722d78f7265994f91b3ab98cd6d56035a6497c5c7465ae5aa93cf5da5a867cf24b61c26a2ae00e989a41fa9794c9129e43b7ca8NyChb0xOxXJbNF/nEdTuumYSKZhupiSOmJk8u/tQDwg=', NULL, NULL, 'Y', '2023-05-19 09:56:44', 4, '2023-05-19 09:56:44', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (15, 1, 10, '1999159b42f913cdd58375c5cdebb4e44ec947d93d477e90c117cc29fd11dc533ae2fa305d21969b3dce50823ba8cd9d47ff5e734b20d7425df9d9991c685e9cMNbDFx8AkNf6Z1cQBm66W5IHcbyRNLXhcEnnpSs8jns=', '089600d6c5df3adbcf1b54e40ecbcd99e8fb2f7141be529bc95fc2eb5585f7dafbbb9d08d3e78fce480fd479d6bb64eb5a3ffcdc0a26a645a2b28f84e2d5d033zG8hCZSk5XgOKSWyoYSu8PIH6SuozVju5brTl8h9D5CDw4smbQ2P+yqdul1d2Tdh', 'ce5c55544415d194c6573d8998fb06d80042cce59cd92311d61f59d81eb481dd174d28fd8a89e113e1a11261b21de36879a42872a4b2f6a00fa97187b0a8de38AaWcRneR/Dg+hYs+rzVbkuMY51Dv5duY5Rnrvrv/w0Y=', NULL, NULL, 'Y', '2023-05-19 09:57:01', 4, '2023-05-19 09:57:01', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (16, 1, 11, '1873bfa9f3a03e1d0765242bad4cd95c1dbc853fb30f69abc14022c6bc810cc6a92ea16e1baf36b03f0290b53484eb20160b219d376bc590f92714b59dfac121X6z9+j1boN6lYEfikAubdxelDfKBmLt1rmHxuKhJ/jo=', '361bd9279e98eb8ee8a6fb0321e99f55f78265d94d17b44f0641ccf0464ad07425edf1e53084230a33c0c3d6d1f5ac841a0ebaaf8398d18a1d4802859bc2cc4aJe3FLa1vz4sJ2oGmLQ0D6uNOsQ1n7pR/tOGeaz/bNUo21GfqGNgEFKEfPGI7MD84', '7b995e4bae87251acb9dfca5e54967d8b08b85e5e7dfbb36b0b8e92e7d687ee0cd06e9f8f7972796a6c3ce0bfb3fe35fe31f306292e4d6d684735eb6af6bf8d56ZmT9ccnkHZ9mh6ECqhwLaM8oGLVp1PGDS8OVvXlwKk=', NULL, NULL, 'Y', '2023-05-19 09:57:46', 4, '2023-05-19 09:57:46', NULL, 'Y', 'Y', 'buildingName');
INSERT INTO `loan_input_master` VALUES (17, 1, 11, 'a9319f40d03f43d8bb24d54276e004195926fc135a9cab438f3870f2557158f92a82ca8f88faacf460a84b015a2b7e9d6f8c3949a9a3eab13f29fda7b1469964clg9Au6JQ6xJKwhfeeDGv4DSYl9ktlDrCKbibPFm+Pg=', 'a072d672fafa649abea32dc51b4d2be9c0bcf43f5a71ab131ba9c3b94a2275601229abb67f6dc757c9788e704aee33e8409673d95ddac7e3ea24f1ea7524a76fMw6Q7qPvBIYrASboATi33LfGdVit4vZj74PuGCNsxVE=', 'c78ff1e4ce839445aef3d9a0c5cb6bfa2f2422264c093f2f848157f0807f503ecea2fc2b21d27b0d243aa892ab25951e4ff4f6b15bd7687b5be134eaaf061131m45mTNQX7RYdY1bCo/uFgbMzFZqSogRLt0cu+Mj2+aA=', NULL, NULL, 'Y', '2023-05-19 09:57:59', 4, '2023-05-19 09:57:59', NULL, 'Y', 'Y', 'city');
INSERT INTO `loan_input_master` VALUES (18, 1, 11, '504972555c4dc9d79c9798f0a93d344b7e915a13f5a2069c11644f15328fbcb17d15e38eccbbd078279f93da3c4cf6dd0b63ceb3e3e6d16ecd45cb85dd169c56MiuuQRPOwz07mubGsGjP9SA0wwbFInhFRdTbovU7Jzc=', '5210bb7c04a3caf4b86a313068eaacfa5423fdfe83dd6655254296b9a8ca93d37b4d6f97988de0f01f3994e812d52503c77c0f759e969ea73ec9eece68e02fc1nWNelQ5ExcJluuS0kicP6gZfjNj6vTr/1R53QUO4P18=', '430d879317c804485a7ccd95959db038b967c2cda973165417bb80661e3045e2d33d7bed3bef71a3d2638903eb367f5e53509da7cd81e456a54f75a83400c41eWumzpnPb2Ir6GPuriiklK7HSGoPBp/OIWCktP5BfQXg=', NULL, NULL, 'Y', '2023-05-19 09:58:22', 4, '2023-05-19 09:58:22', NULL, 'Y', 'Y', 'city');
INSERT INTO `loan_input_master` VALUES (19, 2, 12, '7f3f387ea8363ab8e17d11884bc4914f8250451044c543cf7c3d9050d26d37b6ebabd5ee42c266dbe1496e67eedf86a55bb8d4a77a26eda388c801681fcedd5d0ZAHuV/ZCHe2OJSk3YlIcNIwt0lWskNFDxWO1pGYdoM=', '02ac62434d1f6bb751264c418069e73b2a9cd155fed886879690e997b76a80248a5db76746f1c582af0cf7473d308037b9ee6b875722c41c21a9621b8871197cDMFCU7MlQFlCkpHF5pMMTHfZ7mHb7N0ZmzgoJTSceg8=', '82ae3c4dae72170d754eb3f08d1291add2bff7cf26ec3baed53162eb7555bb4f0e2d6b669540fc2ccabf74331c85b1bcc687d5191fc945f418d6c99c20f46ab0fj1SrZjN6ga8W1etwlSiP3RLa7vBnJN8VQ6nJMZ+T0E=', NULL, NULL, 'Y', '2023-05-19 09:59:37', 4, '2023-05-19 09:59:37', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (20, 2, 12, 'd5bce11792b1db4ed15c6ae56c9ed6112c6654cafeaf775766339a82bea1974147316ffa7d153b0d99e43ea31776e120b4a57d813dae35741dfed14a7534a83bPvKeEjjRtbhdJRMJYZPeMGD8M6kRsCO+00WxY3K/CEU=', 'a1fb336de4161de2fb444dbc2e3bbe45df6e2ef55e7068ac6a40ebad6a4466ef8b935f3a0a7d8357b389ae3d3c8ca5c7327602ca83c4d0f3bc69365e878aa062fBM1PI3u26YLoa+/ii/6fxgQYbYE+XpN1cp/bBt0Ke5hGISKHjDCIJMGn6iBWhFq', 'c0edd410072ec67465159c39407e8ba29b9dc37f5ce262b87ff8f66e6cfc9705db9ee304d71433ad720a8b37fcbe80d2b71b272ce30de3bf40330d715bde18b5R1TN1CK+QCTwzh5dglOA/dko8sW1JpoOP0VMytdy9CY=', NULL, NULL, 'Y', '2023-05-19 09:59:56', 4, '2023-05-19 09:59:56', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (21, 2, 12, '1d8747726f6d54c9f2eba76c23d9eea8b093ac198e707041543c3527d24f91bbbe4d865e9a2a20b3456852ddbd6c2170c8af1e3543cfcb592b8dcbf98c512c55UJT3ZD9y10ibhvhEqAI5HCkgcybvutYJ/n9UJMVpKTs=', '6c5c7bc3ba349f2a5fef5a09d535280f2295f80bc6fee8dee44372cf612e3b254434743900f9ed333035cf67740b52d2ae03c8768df48f215d1d1c5f4fc3b2f0oDcGphOKc35lEn38mh/prbBuqbY3BVFOpwYnPt+cYts=', 'cae556b561907d91907427cecb432c81c1c73a85892f3e69131c6097facc95bd17e290e4a4b8b26f4fedf3fd431118e061a6dec820a921bdfa7969079d6f37caV7Q7pd5LU7M77xH7zWlWuvEf64aeBSCkMDqImlE2FvI=', 'V', NULL, 'Y', '2023-05-19 10:00:56', 4, '2023-05-19 10:00:56', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (22, 2, 12, 'a1da69a3324e584ba3bd555a7e42f46433d3f22279e35d316097944f76469c746f30f7dfc3d9e98bc3746dc9a03228e87054d05b8884c179cd57f15a67464a58qB/ChI6YbEZqqjnUzLbVt2HZU5eqOczPys8cQ9iGbD0=', 'a06c44cb5a45bfcaf17d4cb4955d18dda90842184b3ce2e7b2c5fcad5653eebcc4543c4fd3a0ead9a589b6b93ef1785d6baab995494479251548a74c8c05f021Njkc6r3ADV2QjBsmnSfOGfUOmY0Sti4uMyrnJgXzzbQ=', '7f1d957fa6b11abc6f1c30fd0002b8276342ff312954cc620dc851e3ca6c4b4d14ba4ad888296082fa81ae14384f61977abff68d37dfa3fc30fdd2406d00b980hOO6P6SLs9Vh8jiuEUjwtd+GYL/p3jaMs9Vaa1k8Mz8=', NULL, NULL, 'Y', '2023-05-19 10:01:09', 4, '2023-05-19 10:01:09', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (23, 2, 12, '7e0a61c98f34c2f9e38a22a03505df515af6a3db72dfd8bf316eacc8ea8d353a9f1f96aff293f4b09e764045a3fcc30a664e10fbc22206a51ebe3b80fdc1f61cmqeVmKROlI4SzSVSy4mJ8n69a4qJw9H0YdOcdtP4Lww=', '43d0ccae68f4ff9f7af7f7ffc7358306ad0da2333a2eb689ec7762c1c132852a9c9692eb397921ca4320622915e198f2342f35c6044a300226f72dd776d8e58aIMblUdOz6D/gtY75b0fNN07PRimsWEj2y+p7u38IG2k=', '61be466f06fd7422aaa487c05a77f551c093151e061795c750759136702715d3c3ac79008783f3f293a90fae80621498ad575fc343648c2a115c3c727f057ae7RD+7QmEdD2xSgTer6J+PI4kNWKVpnxTvBgbIUIpChdA=', NULL, NULL, 'Y', '2023-05-19 10:01:36', 4, '2023-05-19 10:01:36', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (24, 1, 11, 'a22898095816b1e84a262d6a3a8d9c25f37817a50a6d2d8a24dd5084a7f600d453bf4d51e94bf4dc4d98cc34cca11777130d693c2250b113d030fca5c4a7fe29aCCDrz5lqGykP9qzYa9awbeKRuRt4VjUuIguwFgtZjw=', '6bf5f1902ff79094c88b898548265dd329d33a99b511b1f87e2e6120162a234ea50c7c2fa19cfb0ca076345f51e40632b63840d624f3f9efc48008ee5e6084ecMSvnEkXSqYqRrDILo3x81I9agJ4vXuQ1Y8SCBe9Fijs=', '655190fae7b37779918dd06b1d931f3695f8244785e44a0399a638a8026b29a2911fc2aca565059d6c28164bf9211de8aa5924dc43fdb4de874d1d23f050b865ew7xPZZkVKYS0utGBQvDOgajord2EFx/94N5gBHMlj8=', NULL, NULL, 'N', '2023-06-17 11:54:50', 4, '2023-06-17 06:24:50', NULL, 'Y', 'Y', 'city');
INSERT INTO `loan_input_master` VALUES (25, 1, 10, '70ff40432f3086c041e4cee7151c578d88520ae8b502b0dbab28961b397e6bcceae8968e61a63fd8b36b6d0de8d499c9af6f785bc7d01d57c2780c957ceb623at9Kze+bHbkU8qSeVmVvK/A82QktXjpCkwJesqlwd28U=', 'ad0a5f3f3f59c2e1195ee97dd02ca528427419b67243ed64640f8bcf9932f8abc09f886062227b4abf9a81d12f652d95ca3b5eac9affe76d40f330220a1a74e95Pnhcgup+uoHncsUrdu1vwforxtoxaglAZfZg8QBiC8=', '08871b5ca34973233c891e335844018b2084ea1947a52cc71f5a6a1f45675e1b0a5206b6463578c7970fa5f061034adc748e61642725754c53c4be4839c08d7esiClG5TJMnHaSFw/f63XClUQb74nrVVYuZoMoAHfct0=', NULL, NULL, 'N', '2023-06-21 22:14:22', 4, '2023-06-21 16:44:22', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (26, 9, 16, '41a867375772305218efe98ef0304c24436522529c2c0b37c238efb6c05d133b23b3fbc8ee774295f87bf7e1d2889676dcd6e789c4f91448f37cda4e737aebda322TfsLcwJTqx51KCefAkyOK9WMEkQwJbngHIDtmCsk=', '820be038ce1ab4eddd5d13505af7a4513e11b57e249fec0dfe109a9957ae4d9797ed6d8af75d73e62cd320673609be7378d88fc202a02974955a6d89374e563bV4/uo4lLFJxwMMxg3kyBjbFQ7CO5E99LN/mc9gMmaMg=', 'aaa072b66b2a270e253222f966a9812ed0c5b9be0072827489e392d784125b62635401fcbc599ef9e251ada9c2d1d73dd0070d29e362a7441be27e42d992ff61Y5F1rFi3EbDY/t9yzu+u2VmwcD9GOGZwcd/HQtgFRyc=', 'V', NULL, 'N', '2023-07-30 16:12:57', 4, '2023-07-30 10:42:57', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (27, 1, 1, '27539c3d08a148ee41da76eede01f3fb42cac363afb0ee63b56afb2c056ff2d691dd573289e5a5b31257b829809dba4f8c3c9f43253dbad17b3612befd44f3ef2lPDlq5TkgDMkU+xQUZUO0bITz8x3N2P0M7e11RhsKc=', '93b4ae28672bb3bedb3038b6265765a4debe88485e7559e2560e5bfe14c2983bb9e53b9e43755aa429ba3311ffc21a2fa4e363ca97d5524cc55f9300d6058077hfr5WUGCS3Crm+4BP6MNxrMv56FX8SHeAxfHHCzXDUvmoLUl/TyJGuzTHxci+frF', 'e29030f54d05889bd047b84b48bba52cc12ac6dcbaee7afcfc240a503d23147a91ef105da385b0878be000cffccdeed67ac847edc65122913897d820cb3de20dbl83vtR/Cin6S8/HSW4hyu8F34anBzDp8OpR5YkKk2U=', NULL, NULL, 'N', '2023-08-22 12:35:27', 4, '2023-08-22 07:05:27', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (28, 1, 1, 'd14bb50bc16a7e101f3dce038de69727500ea5306e58dc93439473e2f047bea52a765dcec99c6f30c3ed1bf321f09a75edf9964c5fa8ba4ad55c7de0bc3c47fdQPYHsVzMEefnyAI5AB5YIkAJcaRd/TXJTB+vpRM5ty4=', 'e701a4099ed0ad8984110f5e0fe3bca0f4684431b4ef0609c16782e8200f0f0a27b8789c66c2fd9691c64f3118eef21117698c8dce61cff094c13d8948c03a6ez0q5UAN9CTWP+8JFNU62hWsKUoRatIRdBDwxsDSaKvbBNV5xT7C89zlGd1czQiX4', '938f415fc5fb5dd8d5ae683973c73a5604813811d55fbb70bd05472943d14e85c942062f04a5f4c0736a6abc9dffa825b579f905133aacf659e28d5bcdfdf23cTX9g8LzWQGA12pV6JvZ/pb79x6VZvTJ8sF1pYHX13hY=', NULL, NULL, 'N', '2023-08-22 12:35:39', 4, '2023-08-22 07:05:39', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (29, 1, 1, '6c7bec0018d82d5e8645999f3aa08a7daafc9041dbe24d894dbebe53eccb8a89a0c87ab300ab0597578a81f877959a0de926a02749f15f1be47f45cdd9881089UHD936CGOOAdYKwHbKoXpDkO0TR6+ac1Zh17A2bhsng=', '5b6dc5d46fb92c9fb4d1d2abe7c32c5f10f3a320705d22a062daac1ebda6f0f3a3c401cfeb28c5541d9d9c5f45e1776094f571cd12a58f396f86da74c6511c8an9etH/EiA/4WmFVZvK0mA5hrHBFYTGFUjn/gfk7sxVZLRyHDqyOhDbgVwXLhL9j6', '9fe164cb74f3a7c60cb6b58c8557a25a7c684fe38c0c0e040af80d905c5ca41b6642250a6a10cea139689dd7268f9ff2dc9d2a070009a134a662a6025aca78e6DPrGo7YoGWpLOiYylRwG/Av2q797j/Tef4V10Vm+Avs=', NULL, NULL, 'N', '2023-08-22 12:35:52', 4, '2023-08-22 07:05:52', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (30, 1, 10, '3ccddbac3498ec8538b718c53ef0de67b44565ffca62959247249be92f9e74f38495ddfe98e67d9fe14c7efad18b0ac4478f503b96dae9b8d367ee1a4de297d8zwxbb/KSOl1glPjuzY1SdjzucJJya7uvt0d2Y8dV6zw=', '12dcb5e93f246e7cfafe6f420e366ff3ef60778eec850c03292d2ce262d74f64d534dde6ce2876b4fd575959654837d2e195d9739688a1576e6dedbd29ef1779mu+c+ye0S05xrb92Us9sclSWicwnojHQJZCv9O4LctAQL4DwsNnsOr2Eryc1MsPo', 'c0617e7c8e67c6aab9c478971805157454648087f5955bc213b9c8bcbfa185092daefc80d4f192870a33aa1d52c6be3b324779b976cc283efe911b7599be766eiZpqxOmQCFmVeFeWRHCqVV9kUyHto1H4aMbwU28zci0=', NULL, NULL, 'N', '2023-08-22 13:54:56', 4, '2023-08-22 08:24:56', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (31, 10, 17, '4b0a1d4ac3db9e1fc0d4adc344a364cd88e1eed69b3daeac629adb11483bef42753da0e36348b949738f1424d8eeff43a1630ac367f7b8d16adeef87c5cb3220lLXZu0iYaHY6isiMKx5LsnGNC0ZCSAzURwv6wEDaFaI=', '93a7f40c0909700795b2cf66f5e70092bc3b33e34934df904806086b99f07585b70e5bc019c3dc422b20bfb38c008287fc4f311e9bde3b75a81402d721ccedc6RdUpF5n5ew32eBjJSszrGLnfYcuNjiwQMIPh6XplkuqT5v3cPgW4cCDPF/ftvcOo', '8b8e9bc80f42b75ca0cca334f73fe2043bfc3b358dd33d0a547e741d3e8293cf5001457b677215d99cba339b677ab740fd854ea373e3300488b57c2be1d114c6A0xATpqpVjsbOBH8Uqbip/q3sn8FHBIzrh031TWLY48=', NULL, NULL, 'N', '2023-08-23 12:14:21', 4, '2023-08-23 06:44:21', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (32, 10, 17, '3c17cb3480f526a52ddf50c80ad78b50a112d1e9a8a0e69c1a65802d9dc5cd021535a14111ff8b61c1b23f050a0662799f68f40b9c728584da98596052c6efe9e5nvyJlctgbccOuJlrfelruKRqRawMRPc70A47yDB1egK+FtxSfcp3ogTjfbMjvM', 'bd2412b8bcd79cc3a2bcdc2564b062cdc50942ad7cea7b0db962d635e1ace90b9c2c5c91419713f97a27b325a9ed19ff9a4c58485336a9f66b0807a05a1ad8b4DPrCbER1ZTvj3/0Zp34MmUBT6DYCRawpB56ctgZ1QzSQy0B8GAe91eQhqRt7ycDr', '99e1f776a96cd136950e03f1d42686bbc9b30a92e2ed7b16994b84f14c4d868d90e4fec6dc06187a61d0d89617eb4bcfdca22465735c5ebb3177fcdefef7a2f5yfuyPOpBOmrcItnuySghrJkmwukBU30xRdJ3LD4hppI=', NULL, NULL, 'N', '2023-08-23 17:13:20', 4, '2023-08-23 11:43:20', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (33, 10, 17, 'bdb846fee36e121ade04e4bddc3d5a61d2e34067f5dd93128e83c08b7ff2eada2559f53378881ffa40cbfd622ad148d9b035d9ca2a4bf6e2ceff39ba9e47a1183IA8ieqKOjzgr+r6DBJgum5ExQLhY1bNXzVDMS75+iY=', 'c157faa0d42b0f9d328b4c2eb7409104a03305a075d318dd139f49f4eb99bb99690e0a826845dc4bc1189fa26d4e113a8fdc97d69a0fc13c41a2c649c302b3f5KKs7YyPDiPQqWXqQxvhPXids7trjIvDnCUWNU5TTqME=', 'ca0cdafcf6ac264f773057adb66a6b9cce442dabd1bfb0d3628d4acf880b393608242cef39850fae17cf20e8e27577f8292317d3b58e96f9c9b83198496a8458QcnHtZmoCuAezOqPIqV0KMuMuhNZznD4eysgpNcJN8o=', NULL, NULL, 'N', '2023-08-23 17:13:46', 4, '2023-08-23 11:43:46', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (34, 10, 17, '96bbf9acff3141b6a2e04f3cc5257f3de3cea45765b8ff619f3b2ef01aaeec5a3a1fd92edf001b851101ef7142aafc350ef7655b87809cbcc63ab5e637ee91b71ePUr2xbCOTp9Oq9USgREUsaK3kdesGf0WB/WGwYs8E=', 'b200481bc072056d9c3de5e40afe9c84ce4ac4d972e2d2f0db5cf95eade1d2ac2105f34ff2c49464a51737e8da1f80da115272007a1ad5c17cd1b0a4b1d5e131pUmoH+tIrvylZLC0v/mh6W5mI01GGx62caFybXW5jskrMaawg/FTUpwNIXWa6Wx/', '2c6cd00deb665e4910c40df5877ed7edee1f528b9a8021c1d419dffc418adc08e7b727189967417fac4462df79820abbb9812b75c2a78aa896ca4f5fa9e06f87+sQXqPsMb2GKf+55RoCVuVY4kubOrcreqM4R/9bM5KA=', NULL, NULL, 'N', '2023-08-23 17:14:10', 4, '2023-08-23 11:44:10', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (35, 1, 11, '7ed322026e744812514f8eb29f3356f31723a7822fb758cf4831af1562ae4243af48f30b161e790a589c1dccf3f0f66928dc279d6197dfcfc0e750eaacbaf726VOjmuvwDH6iG6IzHxlYaPU4pK7FzGTXpCoTLeKAf9ZI=', '0aedff372f11a4e3b509d943f9d86f9520096de2ba93e84602495d94f43ab303f7036d8555fc2219ab529400fa0d02bcaf55822f50d06fc332763ef245fe5e37zis0kqgu0Avlp91dwOUmb9rTmNYn8fbYgWFHMN8j5aytF/fiDx7s9njmfCz2ybkG', '267cf131cd6c07134cfcf966b872bdf808c72ad4fa5cc552d08f79e917de3ffd9cb6ae09d8e0001dd1b754630235363f1eeb4255a05ef3ea202d57d63bb1f00eBxvT7UlGC7FTbExaZ75eVOM3n4fnr2DG3EeO04/R+gM=', 'V', NULL, 'N', '2023-08-24 15:31:37', 4, '2023-08-24 10:01:37', NULL, 'N', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (36, 1, 11, '49477ff1919ba9eac5d7b11f269dfb9062ca497e9a9c1a6c9d18866e19c9d86e317ffed7a3a671584cbb1136d5d52ff10a3aea1fdae060558e8aa6c2f5eda5f6zsLF7lyFkk9rZqIyuSHlaqfd4e1+ikPW1ayi/SfWoas=', '6cc73af73f04808b9f1b988df5cff77a80d7a88c33390f800447f95f5fa9d65deefd9c388ae68380326922a4fd75f8219f81e39a08c949a86fa6ba0a1a0af721WJAwESF18yczADddfAe/gK+yG+YSmVwDdX5DEp0snwk=', 'f768ca7c9b2203bbe885051026401ad763a65b64026b764af0434ffab2d7fd2aa415102cc2e70318faf3090dd9a3125d00194674189cd1e434c8df69f8381be5kLd2tOxTAqZ05Xjlpq0PAy3LHhA65w0Nid7VCl/KI2E=', 'V', NULL, 'N', '2023-08-24 15:32:08', 4, '2023-08-24 10:02:08', NULL, 'Y', 'N', NULL);
INSERT INTO `loan_input_master` VALUES (37, 1, 11, 'd6b993e86af4d3b45693844bf2a38e4ae496b9cec4baf2b8934a0de9e8b37bd4b91bbb99673df0704456acfb556e993b27815915410cf8d9122569a0ce32ee3c2bEUM44fVr/IxIJ3TSfsYg70x/pOFOMwCoGyoEtQ9Yo=', '69668748fa9a17f188ddb08067dbeb721b987021ee2907d03f28f78be064f0fbcc2bee48356c6a8fdc0680493051b5380e4013e2ba387762be751a88bdb5c592IfWxydY+QIKlRdF+SZg8UY9jXage/3NFnu8Vi4KMfyIKf22RtSJwJad3f0AT1qQn', '4efc7bece0863af0842ffd0b7cb8f3996fca5778dc9791a233f43dea5d1524c2ad0f3044408e042b326346c354041ce60b86c8f5e97cf3c3c79dc4990d3a93bbUc3JctwlIbkwTqy0sR8SGeI03QXjWunClwimYqP55jQ=', NULL, NULL, 'N', '2023-08-25 13:05:30', 4, '2023-08-25 13:05:30', NULL, 'Y', 'N', NULL);

-- ----------------------------
-- Table structure for loan_input_master_select_value
-- ----------------------------
DROP TABLE IF EXISTS `loan_input_master_select_value`;
CREATE TABLE `loan_input_master_select_value`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `loan_input_master_id` bigint NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `display_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_input_master_select_value
-- ----------------------------
INSERT INTO `loan_input_master_select_value` VALUES (1, 3, '820555207c719e2c741775e611e36e59093e4d819e0331b21584e2679f918fb439e0ceaa6fb553e2f30786175859dddfbf9614eeb6667822dae9b2f47be1c2fazUX5laRq9B5t+KFcV1GLmnRJH0c223LLG0/o2RDMLvw=', '5d0108431352f97ad68afa1afb86dab78d56b213039cdb2e9d2d4148011dc525fbb5975244b7968d33f67135f26ebfdce84597335e0d2fe3cf54cd5a724b379bfZyPdhjt0KWTO9MZNXeJeDwCGkW7sEG2GT8cNLqO6DQ=', 'Y', '2023-05-18 17:46:06', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (2, 10, 'a7f548d57c204aa67014842433777aef18008650bcb3501881995d13280ed8341014a7e23dd3459aae992a6560a618e1098002bdd01f5e0fa9841a6f3badbab6LPlZWbSHldSilqRhTE0sw7sLtHRN74nXvuRXD2cHHEM=', '5801ef4c725242ecdfab58f07b1aa2d7f3b4ce69cf4051d00d5df04e9f20fc359356edec9de73ebc1b20a0bb3469e119128519d45c73e069dfa0d972b7fc3448wGPJ0NmUSXqef/UirQEhzLokpt13RkUT+sU+omGH4yI=', 'Y', '2023-05-19 09:53:54', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (3, 10, '7e43a3fbbd69fc4f101850292f4f86bfa6944a7a02b74b92e18c71072add1e1bcb17e0ba2ad916d021360c1ff7c3de61804a9ff58b39875bc33136beb96949766FxJ0Wnm6KcRsb/Xd8mecSZV1LJslOkPuWa9MT8OXD8=', '84ae93b38a0809ad866fab86c985049b3003643284f456826ef0ddbe5b62c8a6c6b63fcd95cf3424916507f12b564b3d9164674c84b993653948d7640e97e542SEMdM45zvYx/QZGFq0++/NDULp2vOgFUVzkwdzEWp/g=', 'Y', '2023-05-19 09:53:54', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (4, 13, 'ae23e9dd1c62722257dd6e6baf8196024096fe9ce1df09c58307b994ccb2c2a7c5179648ccdc25c776158609840b273315b0cd0bbe5a1fd20477fba8830e4abf8GuFy0X7QSQGNoPdVVA2X4+mzdsd79oQ4f7ZhyFlK68=', '30969e00431af0790e5b007eab320be420b82c5e6fa2b103b52c264b5252dc324446c063a64ae5138089d82420bbb7406e74852ae7a73e06ff6d040975f280e9w9Z2BLc0kXxcHwbyKJ08Pzc0ZkuACcaBI8cwsbYEjHQ=', 'Y', '2023-05-19 09:56:10', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (5, 13, '3ba0d853e1bf3d500442ecbb85c71a22253aebcbeeacb2d9634f44d93c3eca11edd6b8d59dab5ae2816549c8dc4beb458d615fe6fc844cb6fdbca21e7c341e6aJ8E4sVcNYCeC4avdQYH2pOFoRaCjEs84FwibXg8R1O0=', '4379cc7e2cefb298de354c38b7b2118fb4b6627f686792d67343357c5da7cc0c96a9098aeb1a244f7d9dbac2de33d6a58daf48d485480625897dafdc85dc595bqd1DnGEXDKsV+zFq0Q5R7BaFG5QSeavqujMYnssfUQ0=', 'Y', '2023-05-19 09:56:10', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (6, 13, 'd058dec7dcd31f028848b428ca7bd9bb7b680c70d6a959a81bc2cd17caacb0544455343df68931138650e5347889d4ecd53756fbe6edc865b944362576e5b839yZGJrr8vf8Hj6bfpTo+TEj1Z0aYE6z9g9otxhLuFDGY=', '6537c838b5be6956d90cec0b6e91bde5a5e168b97391b78e03e2abbf61daa16fe1b35383ae745cb247d1c8c54bf9bf77babc83ffc80dc4abea266a9a9b7bb0d3ugl8nJqSEZzsjZ5Dh6jZb4NtSaTulsskwmyT15uK3lE=', 'Y', '2023-05-19 09:56:10', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (7, 13, '91fef0c399cc38716e10277e15632173e3b7b428a8463fdfa7f93214a8fc023c8835db70c449a1ac94f3c4cd2e7ac0dc971005f971a6da4bdef778e2db13ae18sjz4lQxaBmYT0AvJlaSvUl5l65rxy/USuygCEnXipHA=', 'a6d9590b393c1e209556a9bb61462ded3d68c50de976b7b9ee642ba3ec4834e1e35ee273dc3a0a8930d67e17b7272c51c86b21713e297aa384dd5379006ff588Hrxnc3tE1/+1Wpx4cvHyL9qGgESb+TdGWE9hhn1IDU0=', 'Y', '2023-05-19 09:56:10', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (8, 21, '7c1fc5436a94490b6c1e995f416e6b745481703384ece9ffb131e295737182c93010433f5384e58e4d78d3b1d921ea5f4b6e3e87fc4b6c0ba99901f077761439Vg6YIw3Bw4CjiiaHCUc4ITpK2DrRfMnzVOL1m79xhkU=', '697face86d7b7257207b9def6ce64d7ba2c50d94cfd0ce0fb2016421706bb0919b9a7e451955f7cf5c6c3d1c2ca64fefb658875b213e58cc24913c6ba1a29353zJEP25baNz841WIylXDX+59QdtxTB28A0kDBuRv8oaY=', 'Y', '2023-05-19 10:00:56', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (9, 21, '7f2ce2543259002ce08809562e6efb5926d80ddc75d4797659daaacc9c1a45c6e5e1b751acfd6c7c324eefd9713f228c7c892cc371efbc3420d3c761491d849fA6fXjQn2/C7jamfadj3jOfO05dqxprhWj+eYMyZ5AKs=', '94fef6f26b8714fe21d8389fbfc352c3a0c408f9adfa88c1345733d8ffea0795cad39ec6149f0a31307a8a15c20cbd2d68f51b83bb704278f29c9a600bf30af7cQIZla4B2Jp9CaNxN/7d1qwmh0Bvg6EZj+ovhfkWtyQ=', 'Y', '2023-05-19 10:00:56', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (10, 26, '20991718274a0d355e3b885fdb15f1b0c58a17395b3ac8f579d2619206b794968a6d1ac43dd536b5348cbd655fb611ba84fcf7389611efc676a0fe7b2498d1b6hMh9V67poOUBPcAcDUfSNQ3HTXVRl46g+/R4yQ+wd3o=', 'b72d3961e1960e5437e0d98964e29b31801cb9db59da4682a30d7e9965d4b19563fd63bb0282c3a91e3ea3f56728fc4a75e17fa4a198e8f6996df68545c5bbb3Fr27aiWwJCY0GVw2dkkQpgK8iIN+wefqrtXO+yPmJ94=', 'Y', '2023-07-30 21:42:57', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (11, 35, '95a9c808aa25d0a48397cf6aadb847af6d056947519421917e6ccb1e04700cc4e176aec1b04eec49a51fd3e1a6136e628cd69a8b644f77f72c5079ca3ecaedd1x6a64X+QWifm3paACdDc3NQXEvN9fIZhsSLC6dAZAY8=', '0263414b40567c770a0737b4fc3233cb109886877712922218fa2ab83d6cdc6b134f4f15ad8553a0b82cef85abdf9e1e9ef9d89a07f0fef45427be9c5d82125e7U/o3MmTN3IHcB0p/TUJErDiA74DqMWpHyW7UkQLMl4=', 'Y', '2023-08-24 21:01:37', 4, NULL, NULL);
INSERT INTO `loan_input_master_select_value` VALUES (12, 36, '4df8759414028417fc07f5c00b26e29af9b4b7f0b7f53bb73c588b0e9fc44541b012c60bc8c0068d6879883dd13bdc9d55711db52adb2c1f0736bf55283fba19l9blF9RxpzDLC1D7r0le95zjWlApC6PX43beTiBpm0g=', '0d2149bf3d57682d334fa0632f7516c51bda8044bc3b1def57c5df3f112a8b540a0ccf493ebbe696af0a364983f95b3bb1f0c81deab5fee5a4706dd90fab77c4HZPgzqDQbaeYgPP7LpTBXFYmbNq/1pVDPapne5HvU8U=', 'Y', '2023-08-24 21:02:08', 4, NULL, NULL);

-- ----------------------------
-- Table structure for loan_input_method
-- ----------------------------
DROP TABLE IF EXISTS `loan_input_method`;
CREATE TABLE `loan_input_method`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `loan_input_id` bigint NOT NULL,
  `function_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `query` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `from_field` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `target` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `target_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `result_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 29 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_input_method
-- ----------------------------
INSERT INTO `loan_input_method` VALUES (1, 11, 'blur', 'SELECT TIMESTAMPDIFF(year, `!loan_date_of_birth!`, now()) AS age', 'loan_date_of_birth', 'loan_age', 'val', 'row', 'N', '2023-07-17 10:37:11', 4, '2023-07-18 10:24:56', 4);
INSERT INTO `loan_input_method` VALUES (2, 11, 'change', 'SELECT TIMESTAMPDIFF(year, `!loan_date_of_birth!`, now()) AS age', 'loan_date_of_birth', 'loan_age', 'val', 'row', 'N', '2023-07-17 10:37:39', 4, '2023-07-18 10:24:56', 4);
INSERT INTO `loan_input_method` VALUES (3, 11, 'blur', 'SELECT TIMESTAMPDIFF(year, `!loan_date_of_birth!`, now()) AS age', 'loan_date_of_birth', 'loan_age', 'val', 'row', 'N', '2023-07-17 10:37:46', 4, '2023-07-18 10:24:56', 4);
INSERT INTO `loan_input_method` VALUES (4, 11, 'ready', 'SELECT TIMESTAMPDIFF(year, `!loan_date_of_birth!`, now()) AS age', 'loan_date_of_birth', 'loan_age', 'val', 'row', 'Y', '2023-07-18 10:24:56', 4, NULL, NULL);
INSERT INTO `loan_input_method` VALUES (5, 29, 'blur', 'SELECT SUM(`!loan_gross_income!` + `!loan_other_income!`) AS total_income', 'loan_gross_income, loan_other_income', 'loan_total_income', 'val', 'row', 'N', '2023-08-22 12:37:10', 4, '2023-08-23 16:24:37', 4);
INSERT INTO `loan_input_method` VALUES (6, 29, 'blur', 'SELECT SUM(`!loan_gross_income!` + `!loan_other_income!` + \'!100!\') AS total_income', 'loan_gross_income, loan_other_income', 'loan_total_income', 'val', 'row', 'N', '2023-08-22 12:52:00', 4, '2023-08-23 16:24:37', 4);
INSERT INTO `loan_input_method` VALUES (7, 29, 'blur', 'SELECT SUM(`!loan_gross_income!` + `!loan_other_income!` + `!100!`) AS total_income', 'loan_gross_income, loan_other_income', 'loan_total_income', 'val', 'row', 'N', '2023-08-22 12:53:37', 4, '2023-08-23 16:24:37', 4);
INSERT INTO `loan_input_method` VALUES (8, 29, 'blur', 'SELECT SUM(`!loan_gross_income!` + `!loan_other_income*100!`) AS total_income', 'loan_gross_income, loan_other_income', 'loan_total_income', 'val', 'row', 'N', '2023-08-22 12:54:45', 4, '2023-08-23 16:24:37', 4);
INSERT INTO `loan_input_method` VALUES (9, 29, 'blur', 'SELECT SUM(`!loan_gross_income!` + `!loan_other_income!`) AS total_income', 'loan_gross_income, loan_other_income', 'loan_total_income', 'val', 'row', 'N', '2023-08-22 12:55:17', 4, '2023-08-23 16:24:37', 4);
INSERT INTO `loan_input_method` VALUES (10, 31, 'ready', 'SELECT upper_limit FROM product_wise_loan_limits_with_interest_rate where product_type=11 and product_id=5', 'loan_loan_amount', 'loan_loan_amount', 'val', 'row', 'N', '2023-08-23 12:35:45', 4, '2023-08-24 16:53:08', 4);
INSERT INTO `loan_input_method` VALUES (11, 29, 'ready', 'SELECT SUM(`!loan_gross_income!` + `!loan_other_income!`) AS total_income', 'loan_gross_income, loan_other_income', 'loan_total_income', 'val', 'row', 'N', '2023-08-23 16:24:12', 4, '2023-08-23 16:24:37', 4);
INSERT INTO `loan_input_method` VALUES (12, 29, 'blur', 'SELECT SUM(`!loan_gross_income!` + `!loan_other_income!`) AS total_income', 'loan_gross_income, loan_other_income', 'loan_total_income', 'val', 'row', 'Y', '2023-08-23 16:24:37', 4, NULL, NULL);
INSERT INTO `loan_input_method` VALUES (13, 32, 'blur', 'select (`!loan_salary!` * `!loan_eligibility_per!`) as loan_eligibility_amount', 'loan_salary, loan_eligibility_per', 'loan_eligibility_amount', 'val', 'row', 'N', '2023-08-23 17:16:27', 4, '2023-08-23 17:19:17', 4);
INSERT INTO `loan_input_method` VALUES (14, 32, 'blur', 'select (`!loan_salary!` * `!loan_eligibility_per!`/100 ) as loan_eligibility_amount', 'loan_salary, loan_eligibility_per', 'loan_eligibility_amount', 'val', 'row', 'Y', '2023-08-23 17:19:17', 4, NULL, NULL);
INSERT INTO `loan_input_method` VALUES (15, 35, 'focus', 'select pincode from pincode', 'loan_test_pincode', 'loan_test_pincode', 'val', 'result', 'N', '2023-08-24 15:38:15', 4, '2023-08-24 15:55:39', 4);
INSERT INTO `loan_input_method` VALUES (16, 35, 'focus', 'select pincode from Pincode', 'loan_test_pincode', 'loan_test_pincode', 'val', 'result', 'N', '2023-08-24 15:39:31', 4, '2023-08-24 15:55:39', 4);
INSERT INTO `loan_input_method` VALUES (17, 35, 'focus', 'select pincode from Pincode', 'loan_test_pincode', 'loan_test_pincode', 'val', 'row', 'N', '2023-08-24 15:40:13', 4, '2023-08-24 15:55:39', 4);
INSERT INTO `loan_input_method` VALUES (18, 35, 'ready', 'select pincode from Pincode', 'loan_test_pincode', 'loan_test_pincode', 'val', 'row', 'N', '2023-08-24 15:42:13', 4, '2023-08-24 15:55:39', 4);
INSERT INTO `loan_input_method` VALUES (19, 35, 'ready', 'select pincode from Pincode where is_active = \'Y\'', 'loan_test_pincode', 'loan_test_pincode', 'html', 'result', 'N', '2023-08-24 15:54:46', 4, '2023-08-24 15:55:39', 4);
INSERT INTO `loan_input_method` VALUES (20, 35, 'ready', 'select distinct pincode from Pincode where is_active = \'Y\'', 'loan_test_pincode', 'loan_test_pincode', 'html', 'result', 'Y', '2023-08-24 15:55:39', 4, NULL, NULL);
INSERT INTO `loan_input_method` VALUES (21, 36, 'focus', 'select village from Pincode where pincode=`!loan_test_pincode!` and is_active = \'Y\'', 'loan_test_pincode', 'loan_village', 'html', 'result', 'N', '2023-08-24 15:58:41', 4, '2023-08-25 13:07:13', 4);
INSERT INTO `loan_input_method` VALUES (22, 36, 'focus', 'select vilage from Pincode where pincode=`!loan_test_pincode!` and is_active = \'Y\'', 'loan_test_pincode', 'loan_village', 'html', 'result', 'N', '2023-08-24 16:00:02', 4, '2023-08-25 13:07:13', 4);
INSERT INTO `loan_input_method` VALUES (23, 36, 'focus', 'select vilage from Pincode where pincode=`!loan_test_pincode!` and is_active = \'Y\'', 'loan_test_pincode', 'loan_village', 'val', 'result', 'N', '2023-08-24 16:02:37', 4, '2023-08-25 13:07:13', 4);
INSERT INTO `loan_input_method` VALUES (24, 36, 'focus', 'select vilage from Pincode where pincode=`!loan_test_pincode!` and is_active = \'Y\'', 'loan_test_pincode', 'loan_village', 'val', 'row', 'N', '2023-08-24 16:03:46', 4, '2023-08-25 13:07:13', 4);
INSERT INTO `loan_input_method` VALUES (25, 36, 'focus', 'select vilage from Pincode where pincode=`!loan_test_pincode!` and is_active = \'Y\'', 'loan_test_pincode', 'loan_village', 'html', 'row', 'N', '2023-08-24 16:27:29', 4, '2023-08-25 13:07:13', 4);
INSERT INTO `loan_input_method` VALUES (26, 31, 'ready', 'SELECT upper_limit FROM product_wise_loan_limits_with_interest_rate WHERE product_type = `!product_type!` and product_id = `!product_id!`', 'loan_loan_amount', 'loan_loan_amount', 'val', 'row', 'N', '2023-08-24 16:51:55', 4, '2023-08-24 16:53:08', 4);
INSERT INTO `loan_input_method` VALUES (27, 31, 'ready', 'SELECT upper_limit FROM product_wise_loan_limits_with_interest_rate WHERE product_type = `!product_type!` and product_id = `!product_id!`', 'product_type, product_id', 'loan_loan_amount', 'val', 'row', 'Y', '2023-08-24 16:53:08', 4, NULL, NULL);
INSERT INTO `loan_input_method` VALUES (28, 36, 'focus', 'select vilage from Pincode where pincode=`!loan_test_pincode!` and is_active = \'Y\'', 'loan_test_pincode', 'loan_village', 'html', 'result', 'Y', '2023-08-25 13:07:13', 4, NULL, NULL);

-- ----------------------------
-- Table structure for loan_panel_master
-- ----------------------------
DROP TABLE IF EXISTS `loan_panel_master`;
CREATE TABLE `loan_panel_master`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `loan_tab_id` int NOT NULL,
  `panel_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_panel_master
-- ----------------------------
INSERT INTO `loan_panel_master` VALUES (1, 1, '489deeeec83beff6038d21359e7af6bc843d81705dd36b0343360441a439b63b67a4392813109355b5cf45b65b61f54b7e0321cbe9c2be9214a09056cedd22a5f1cio5Wj2mH3plllX9gHIw5cwNuGxS1K8XrWRKq4l0UWMnIc5uRH3zhwkuwd1Nu7', 'Y', '2023-05-18 10:11:14', 4, '2023-08-23 16:23:29', 4);
INSERT INTO `loan_panel_master` VALUES (2, 1, '6b7f3d25af3184d7d76cbb95f9b42d8074ee88158f58d7fd29d406c9c5e05caba5218984548b72b515cca5f3d2e101ebdc7c2c20fb50dbec23744eeca746a7daWpODhT8wsr/b6NeTbQE6ft3bRZ/+D8ULzmo5EJ2MBgo=', 'Y', '2023-05-18 10:14:14', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (3, 1, '3e454ff4dd8670e58e48a051e2870b58b94b4900e308f136573e25229a43ac4f6cdd9c60fec8c3f61815d8f1db113cb5a60b7f48e55015cc7b32889ba3da2795014CraWhx8NYcGOc8+w0rIrJDj3PThmYs9KLsyIMvNU=', 'Y', '2023-05-18 10:14:22', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (4, 2, '9c157b236235b04915a81282e3b394f25ac3a8ce891640e097f2fcef9eb6e0ab3ad920a7eb5f17233c27f60a7fca1c54497cfb435f92c5b5b158ea0f0fcc64a0zo1oSChYp0WxXzqwhmrAsH0v0yJ2v5NaQ64bQL54Yi8=', 'Y', '2023-05-18 10:14:32', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (5, 2, '12fadbd26ddc160c3d7b0b9e2ba8b2206fb9ac726262fb3f277e74bf17c3cbd80a43e0482932cb478db8302831b4f0bb721debf0787a1795161e1d25ea44a83e+2u7MDQ/c6CBymSxdruShv/vVrPUj84GeXIwXKB6Sy0=', 'Y', '2023-05-18 10:14:39', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (6, 2, '9819b25a49463929940a4b643b02186771878e7167c194be0b04d125e80833b9a2dda171dab3390a6daeaea5a43387f2e789c60715dc0b87e030a0a40db4fabcOQyyZNIRB0MYe1hDpr5TSzVdPp7zDMSdjXsj9zbwbks=', 'Y', '2023-05-18 10:14:48', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (7, 3, '318bfda873ab75171e9cb69fee112fd587014553b5b13127e3cbd299f07a3cf864da59017e662a8c7cb27399e5cfded61a5e1fe3e311f76d862cf9afff07b482tV6ocjcU+ewLRZ+UsWmBMdTcT81nLS+HnBrpRMIf0+k=', 'Y', '2023-05-18 10:22:50', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (8, 3, '19ee4caf97e71b16ddf8c8f7a74b8e5574f94a125a41d1cb64aa7c2b2906067db5776b8bb8946588499013c019024a61cb7527d46aa7946366b5c5da4b363f1aWmpUvzJ+EjZWy7IHTmm5e5+nR71aeWKvi0BK1+gzRDA=', 'Y', '2023-05-18 10:22:59', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (9, 3, 'dc9798094080ef2cc0eedcd831ac4dda430c250999b67eeaf87ef00c63e60a249fd4a7ea4d5717e333bf8aeb082d23ceb2ab34c538836173565c1b02ae59bf9alP6J+jxMMHAU7B6azyruFMc9WXncPCNtQbmIk0u0+z4=', 'Y', '2023-05-18 10:23:07', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (10, 1, '6c33acc1bcc2a3a58ecd0126121c0436569694b57976a1ccd996c8cac2395a2e16c646b1b29f470431536898ae1a0b8017ee764402584d156125a151088f7375JC0+Sk91Wsk2EIFDqfCRmeHTKERg2uCoVRy0wtQUiz0=', 'Y', '2023-05-19 09:47:09', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (11, 1, 'ab80f0f26c20da47b149a3d7231567fec07728df84a1ee1d9a3bbbdffa378ecb723f2c6c7b4aa4bcf26173595fa6f60441e7008290fe7ac44236450a2aeb866dTqYXPdbBEzldwbPUg7Z2XzJ8kP2vnXOpcUx8nkaqhqY=', 'Y', '2023-05-19 09:47:30', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (12, 1, '8bb4237e80d130bf9b92246e0c42c557d5ed7e92ed7dae6822101dc95c91c8d09a2be6a828a09fef6fe8e9b546f2e3d9e6fc4c2845e441f81b13be7064c2f1f4VoX6uDTCOFz9wIexRVJgxpXdADWOPTTmBQZcuj4d0kM=', 'Y', '2023-05-19 09:48:32', 4, '2023-07-04 19:40:46', 4);
INSERT INTO `loan_panel_master` VALUES (13, 1, 'b26f8ba12a178d4e64e4a5e608bc5f3920d24e04a93b05bd510b61b744fd5a8bac1f86e2b9c4e38154a34dde8e235d9cee2d67388cde0dd04265973a6ebd99d5dd7YUytTHN4iP0nElpK1by4nhES+35+bJMBl3pGvLGvJ79ZJXMGfPSeXbfKcIOuE', 'Y', '2023-05-19 09:48:47', 4, '2023-07-04 19:40:37', 4);
INSERT INTO `loan_panel_master` VALUES (14, 1, '532b20133ca615b14d307c7acbb443c9e9c175995680af1b9204f141d78b7746962fb8328db0b83165e2dc10c338515305224296d8f9e95df8b0bcb39463acecGHRE5FEhqyrGqwhP5WUP2vGfE2E/X3Uh/MEQkN+/TOo=', 'Y', '2023-05-23 13:07:27', 4, '2023-07-04 19:40:30', 4);
INSERT INTO `loan_panel_master` VALUES (15, 1, 'f7a7b6e20f454076520378f84be30adc970730721f8e6bfc94fb211d8c6231cf65d79a754adf04a36897f10cffbf3bb010566b4924c76dfcfc64309d91e2d5093VOG/zaLIQ6XOV0bpZMD61xV4LrJ6mrd1iMlBzsCdek=', 'Y', '2023-05-23 13:07:45', 4, '2023-05-23 13:10:46', 4);
INSERT INTO `loan_panel_master` VALUES (16, 9, '7c093847c59fa4d5babbd72e38cda04e444904c33ad36dbc611ed3da45c4d9056496adaa389d64efc27e53299b91a0af1f0a88bba797d879097d23bd0a1e29aadPTJjuJhS74BgfPSj0X8jlMVrBZntZjttE38z1NquSnKl7q7C7cMXvcORhrgeJ/g', 'Y', '2023-07-30 15:56:54', 4, NULL, NULL);
INSERT INTO `loan_panel_master` VALUES (17, 10, '5329fdfc46d977875537c32f37b66f867959691cbb57065d2ce5a8d97fe32025aafa463316bb8ea07a9a319be0642ae66d9d3fac8cd70e5b3dcd036197598d5f0tvHt3ie0q2N4J6xFrFI+ktQPgcl/cIhXf9FTk4fRqg5FcZDFI+F8BI/sGhz2ikO', 'Y', '2023-08-23 12:13:54', 4, NULL, NULL);

-- ----------------------------
-- Table structure for loan_tab_master
-- ----------------------------
DROP TABLE IF EXISTS `loan_tab_master`;
CREATE TABLE `loan_tab_master`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `tab_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_type` enum('D','L') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'D=Deposit, L=Loan',
  `product_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `loan_category` enum('G','P','M','O') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'O',
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_tab_master
-- ----------------------------
INSERT INTO `loan_tab_master` VALUES (1, 'c79ad5a5c3f7e042ab33ad3dd28413fe43f9941ca20f1c8b07bf2c5687cb017602f7c08d0baaf58749b653f2ed1cb15eeb1e786e1a2bfbee716f18f06b770fa1voAJKI25l7S3NHaD6eC5IMZTC7BT4RuUSasYZxXhB1+urMkrQWwmUlneSVAHmuoj', 'L', '[\"5\",\"8\"]', 'O', 'Y', '2023-05-18 09:39:28', 4, '2023-09-06 11:21:34', 4);
INSERT INTO `loan_tab_master` VALUES (8, '0b19fcbe2c5dde062cb9725b98ee322062b5e9ebed2b6e64d7c2c0a013e99908762c96271a52c2f1dba19426d82e66362e0d09548ccc38b5b3647ff2027aa49d5VTyKQPlEm1Uf6aeyxFnVBHUK3W9RpH++PyFTqjncaw=', 'D', '3', 'O', 'N', '2023-06-30 18:48:00', 4, NULL, NULL);
INSERT INTO `loan_tab_master` VALUES (9, 'ef596aad3003abfba79626ee5530e2f0d7ba0ac4fce65269ddb292d8c995ecd6267d87c8d4f3973afb4f95892e7bb36247106e5a14f82322991fe4b1d3cbccb7N5EBalLsBOlfhaanbGIOc15wp4EwjM+uMwUSZFPO1f0=', 'L', '[\"8\"]', 'G', 'Y', '2023-07-30 15:56:29', 4, '2023-09-06 11:21:18', 4);
INSERT INTO `loan_tab_master` VALUES (10, 'dcc9c3b285c957d275ee240bd4ce7e900d33808278de868fde513cd57320922ae6298f37bd0d29c83a06c78b158d05a9da80b782ced04ffd17bf4654830eee2dDDHcO+bpidCKQNRd0OTI2K+F/utbyj22jx0kmSMAoIM=', 'L', '[\"5\",\"8\"]', 'O', 'Y', '2023-08-23 12:13:33', 4, '2023-09-06 10:47:04', 4);
INSERT INTO `loan_tab_master` VALUES (11, '030a5987d2ee374d86e366696c89105c49460d8c9764c29020a8ee9f66bc29f129ca367572f27807dac1ce510df5ce89ed340ee3e729d5e7523913ee33debf98NV0j18xE36BCdXybuSESVIzc/Xq0M/sUSnW1+LfxJ38OsmFHyjZld4m9gyifbr+6', 'L', '[\"5\"]', 'O', 'Y', '2023-08-29 11:34:17', 4, '2023-09-06 12:59:04', 4);
INSERT INTO `loan_tab_master` VALUES (12, '1dae45e15396d3187e3594569d7b4f380dc854ce67f1f237ac720a04f6f3a771db1d284f845ebd1797c4758cf1cb4b387baf321dbd3bce08376917f5eb771b757BivM+iRuLsJxNIaBhFq8mcBT1qpyH1IlDTxLyAMYVM=', 'L', '[\"5\",\"7\",\"8\"]', 'O', 'N', '2023-09-06 10:35:50', 4, NULL, NULL);

-- ----------------------------
-- Table structure for loan_type_master
-- ----------------------------
DROP TABLE IF EXISTS `loan_type_master`;
CREATE TABLE `loan_type_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `loan_type_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of loan_type_master
-- ----------------------------
INSERT INTO `loan_type_master` VALUES (1, 'Test Loan Type', 'Y', '2023-02-20 17:31:56', 1, NULL, 0);
INSERT INTO `loan_type_master` VALUES (2, 'Test Loan Type 2', 'Y', '2023-02-20 17:31:56', 1, NULL, 0);

-- ----------------------------
-- Table structure for marital_status_master
-- ----------------------------
DROP TABLE IF EXISTS `marital_status_master`;
CREATE TABLE `marital_status_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `marital_status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  `value` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of marital_status_master
-- ----------------------------
INSERT INTO `marital_status_master` VALUES (1, 'Single', 'Y', '2023-07-14 12:19:09', 4, NULL, NULL, 'S');
INSERT INTO `marital_status_master` VALUES (2, 'Married', 'Y', '2023-07-14 12:19:09', 4, NULL, NULL, 'M');
INSERT INTO `marital_status_master` VALUES (3, 'Divorced', 'Y', '2023-07-14 12:19:51', 4, NULL, NULL, 'D');
INSERT INTO `marital_status_master` VALUES (4, 'Widow', 'N', '2023-07-14 12:20:22', 4, NULL, NULL, 'W');

-- ----------------------------
-- Table structure for masters_sub_group_map
-- ----------------------------
DROP TABLE IF EXISTS `masters_sub_group_map`;
CREATE TABLE `masters_sub_group_map`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `master_table_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `master_table_field_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `sub_group_id` int NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of masters_sub_group_map
-- ----------------------------
INSERT INTO `masters_sub_group_map` VALUES (1, 'branch_masters', 'branch_code', 1, 'Y', '2023-04-13 21:56:29', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (2, 'user_roles', 'role', 2, 'Y', '2023-04-13 21:56:52', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (3, 'user_masters', 'user_name', 3, 'Y', '2023-04-13 21:57:21', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (4, 'product_master_loan', 'loan_main_product_name', 11, 'Y', '2023-04-13 21:57:57', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (5, 'product_master_deposit', 'deposit_main_product_name', 13, 'Y', '2023-04-13 21:58:18', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (6, 'document_masters', 'document', 17, 'Y', '2023-04-13 21:58:45', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (7, 'collateral_master', 'field_name', 18, 'Y', '2023-04-13 21:59:18', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (8, 'de_dupe_master', 'field_name', 19, 'Y', '2023-04-13 21:59:43', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (9, 'co_applicant_master', 'field_name', 20, 'Y', '2023-04-13 21:59:59', 4, NULL, NULL);
INSERT INTO `masters_sub_group_map` VALUES (10, 'co_applicant_panel_master', 'co_applicant_panel_name', 21, 'Y', '2023-04-13 22:00:17', 4, NULL, NULL);

-- ----------------------------
-- Table structure for module_master
-- ----------------------------
DROP TABLE IF EXISTS `module_master`;
CREATE TABLE `module_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `uodated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of module_master
-- ----------------------------
INSERT INTO `module_master` VALUES (1, 'Loan', 'Y', '2023-07-27 17:04:22', 4, NULL, NULL);

-- ----------------------------
-- Table structure for other_loan_mester
-- ----------------------------
DROP TABLE IF EXISTS `other_loan_mester`;
CREATE TABLE `other_loan_mester`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `field_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_name_slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `field_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `master` int NULL DEFAULT NULL,
  `is_required` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of other_loan_mester
-- ----------------------------
INSERT INTO `other_loan_mester` VALUES (1, 'd51db9650160d3b4dd3920f08bcca2d106fde64a703e08e3d6e96e00f231b32bf02e47ff68236bb0138c206b3ef58be6985fd1bf90e694981063bfab25684626pm9Ac4WfPt9JbWOzJixeuKdG/mx+JtRVB5gAgQL73NM=', 'skhjs', '0353ceaf9aabc7bcbc2bafbde6a889654b6e1f383c65f0ec300c76b3a8a2654d19a2574cdb238b896498e956aac4fc015c8ae521e6141230ace20b8e16461847brTW3Clkm38ms7P5vLkjGsBu7gha7Du8c2/tn8Osr9Q=', NULL, 'Y', '2023-04-11 14:05:14', 4, '2023-04-11 14:05:14', NULL, 'N');
INSERT INTO `other_loan_mester` VALUES (2, '8bd79898b1ccae74f72d71c0000a560060d0df155f6f0468fcda555dba6b4f283153105fe06a861475c5e5a06dbdc68b7f99922c2ff1d47b7d76125e01ab299d2jnkEJDxNo15AvK2oxWKirksSuraUytjPWQpnP94lHk=', 'first_name', 'bb8d5b0e661d204d4c0974f237af522fd8d2922798fb463540083e2277be7c5294dbfeba2c9a00a8f9d0d2bfdcb7a678a8eff564dff97c971072dceaa2dabf62GMvYFk6QjRsOyzK03RpS5qj0+uwsoB5zY/Ip/YWF5jE=', NULL, 'Y', '2023-04-11 14:05:38', 4, '2023-04-11 14:05:38', NULL, 'Y');
INSERT INTO `other_loan_mester` VALUES (3, '4896daeab130a8b93d7cfcdf87b3b4e472f3c1d2ee2d97586d87b94c16c80dd46a4139a85a592a89163e548720fd25d843c782fe8c308f6a8a68cc40080bcc6b/JDOE03/yl+wcIj3P03qp9rcWmgrPQ8plnacqLqTk2g=', 'last_name', '242883936c09b16dd02c0a48292afda987bf886fded8efd0ac03a07cd5f6428c724f69fe67ba70bec7739f12c79071c3e2c4981966ff3847aadd87709a0055cdO3eHaaSH4TvdDOdFYKJQUg0u61qc6ET62ZHq83VpePM=', NULL, 'Y', '2023-04-11 14:05:59', 4, '2023-04-11 14:05:59', NULL, 'Y');
INSERT INTO `other_loan_mester` VALUES (4, '4823d339026f21e4b196ee37ea2fd3ec57beca46010f91647f9f24bee948b7c7fb72d89aa8ed2d0c334b0994712a63879ac9008f55559f796429bd731c3de2954eHGztuwGtJsMpCk+nd0jCWHp/Nkl2YaC5aGPLJaL1c=', 'efadeec06a6434759fbf5c49ab05c3fad38501f548d876da98ba71b5e827ab7089a40313fb68b0e98b15e39ea5e5036bf4e3830e7077bf23816aa09a19470304NZbtyGhiLvmj4sgQhHzO1vWm/uDaxZkfl5zOj6caRv/TkK2jIaal+ZtWFJimD0Yq', 'cbb7dd9c8149a0cfb68aa4239f8846a882c900e8559fd73788e1cd87ba2a200dd512e0b6169aa7044ab20cf9a663d09e9dea9a7336e3d2d3b8655d457e10b5396Ta8P1HrrOnooO8GyAm36VweR8uMORbbbfchuUFZmcQ=', NULL, 'Y', '2023-04-11 14:06:22', 4, '2023-04-12 13:13:02', 4, 'Y');
INSERT INTO `other_loan_mester` VALUES (5, '8f8b35265a809835e0e2ed50dd28f137b8dbe4cd1e1b29e9a1ad641b2d2b4c5b4a978be3aeaa451b69c483c0a4f4a3fe4752fdfdac08ff22c924fcd05cb7a618CmUKtAQjIkm19DGwCgdS59XWvaqQh8qStf4rBDAy9mM=', 'b9d67a1afe8a309ad692fb656a9d481d511c33f2cdbee856a6776a68d1fefebea29f81dab837ac99ed44d4c859380b29fc00cf809cd77e1e0ef91b130b838bf4N9U6tUygKKzLaHkSZeRQPekbRUSjR/Byg/UgjXAleImscJFiZXqcaKQR8HPPYrnU', '366cab106d5832d701487beb0250bb1990a7aae8ab3b399266972cfaec046b45d1f0e0bc72c962e33eee721d8567dc48898632da72bf9193b4bc68a262cdb738lOQtEmSmoOYjmQNLbDecTAWo/9DqfGpFa+ZavKZIBWE=', NULL, 'Y', '2023-04-11 14:06:56', 4, '2023-04-12 13:10:01', 4, 'Y');
INSERT INTO `other_loan_mester` VALUES (6, 'a834df82b3c95a6d548ea97c347d195d4b7dcb4a331f8954ae24b88782e72fa2a93b43595fbd6667040ff6aebba4b8b51df0cc22de113a3588a1a2de655200d4c/o0SjZCWXNmTa+hEpPdfAKzX2vBjTLUDquAP+6fTEs=', '68dfee9169be2fbbe77715dc8d1800b38bee57c76132097e1086c52f7532c1d7bb14f4ee951b6f01a2b6acc2a4362a34d15023e59ae783aaad6ec458807ab8cbOX/QmxUzbOXvvkxHF0DxZumvxUoYt6DKm/HbDDQ3EnLFR46hqRQm37M37n/Ct6eG', 'ab452c5ceca5d71d3bb9ddaf19184e7cea0d950868588f5508cfbc607b1fd9edf2d8de30abb855a90658d4a635c374cedd05b9f9ac64a154dd771edbf35a22ccYE4oVOHOkduHnp9xbSIwmI3LSPRk8RebBuJpldoms5M=', NULL, 'Y', '2023-04-11 14:07:16', 4, '2023-04-14 11:01:27', 4, 'Y');

-- ----------------------------
-- Table structure for pincode
-- ----------------------------
DROP TABLE IF EXISTS `pincode`;
CREATE TABLE `pincode`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `pincode` int NOT NULL,
  `vilage` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pincode
-- ----------------------------
INSERT INTO `pincode` VALUES (1, 522414, 'Dachepalli', 'Y', '2023-08-24 15:37:23', 4, NULL, NULL);
INSERT INTO `pincode` VALUES (2, 522414, 'Nadukudi', 'Y', '2023-08-24 15:37:32', 4, NULL, NULL);

-- ----------------------------
-- Table structure for product_master_deposit
-- ----------------------------
DROP TABLE IF EXISTS `product_master_deposit`;
CREATE TABLE `product_master_deposit`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `deposit_type` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deposit_main_product_code` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deposit_main_product_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deposit_sub_product_code` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deposit_sub_product_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_master_deposit
-- ----------------------------
INSERT INTO `product_master_deposit` VALUES (1, 'f77a3a28b1094cb8eeaab6d7088c4e9c75d6a8e4c3cc597563cbca8bde0ad096ef0497fb569a2c2386fc1e158bd3181b086236bc175f8fbf654ca2cf34b4429azExoDORMHcgQal+CZ0Gud2FHHtpC+eZQEkn4KejR7jU=', '755ec13bcedcbe25641310dce94df4c21fa5dc9a8f59647acc4306e2f86897ba65a93a2d803cef06e2ae46707caede75d15e39725d86992ccefe25f8bcfb6622e+wy225UrQ7C1oIK74Lytq+p9JFeOI9DsTn2a7CneKk=', '64d614dd2318e19cef2275516bfc0d10c08878678bdda9a370577b8ff0cac5405af939f28fef0e74391b13427873d221ce488238a5cff88556cb9e4a15aa269cIYxiWF8WeVv6DafdtUG03hcG6MalfRRouaqMMUOugU8=', 'eb6863b8ba0bd348278933cbf6c15654bbe07e8679b60191c5d0bf41fe969bd6334254b360e7f45d71b73e6c55477d0c00da5d3c6e4710152342b4dc3bc1f836uMrCwqN8tZ43Y7x2t4LemV3QaJJcK4PUBhzgftODD/Y=', 'cf4b86b5b05b2c1f40893188675929dd19d789b4a6dae527003eec461f62a860bc35c4c538c099e3a376c100b78881d5f42c82fb9322f5ee966e5927eb137e8a99nai9gohGhA/euW+ZgQ7rL+0UqOMGE+5TPpdso81OA=', 'N', '2023-02-21 14:54:02', 4, '2023-02-21 14:54:11', 4);
INSERT INTO `product_master_deposit` VALUES (2, 'e32249577efbe53f7b654f4460826fa0c0cebaeca18dfc523155e2b6a9d3f09022467727b44ff0d95c22fbf73acbd9b9f1c78eb440c940b9132143b82dca821fncIg3LWgdsW31sP4UdBY2D6DDm+MA1ZJuIhTpk1o8kY=', '1dca4c7df16db94ed7828d542cad81f74868a1cc780be71525fac67f38f8848d465f343cd47193f5408d4aa56fd26ad6482f65381774cd1e09395b5d00bd53d9qGI/PrJKd9jLDxd4Q/BZtkq0S0xnc4oRCFPyS8qUHOOHIXtqLGwJzxt7QSQosnwU', 'dbdfb1bb7f34ed9fd99f0c51e9a248789be8e8b0d377be0a4e97bba4d28f0506470bb8ff0862e159467a480919e0e305e47f39c61a8184bfd5cddd7e77c522c2gWH+Eg8M1E+G5dSAufv0UCD4zO8olGrVZlQBh/lkH5gwZVSVwXSrG/5wrXInGDVg', '9f02161aca5873e237ed54523180e3ff1e37c78edd1b8a87ce47669b48d6ed63c3879ab61c1420ab210745a33d2f0122608c54bb9de3d55d9bdbb49f0263cc4a1cyF3u/qMtFt3gnq4nJ/9awvSAKebYQjHH9tCGJHgCCEO5Rt6QGmXeJKhZgVaAzm', '782366a309f37aed3ff30e8e1245690157338eb0320e68bdeb6c8615be3846470ed509efb6fdfc08f33fe038caece223eb082b38a15f57b5faeb124d99f35aafJL4pZVUx0yB3fkP3J1XiqJSgsIEaMgyaJQ8KLO5cUFbr7wtZX41qyUVci0FD2ivN', 'N', '2023-02-21 19:18:08', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `product_master_deposit` VALUES (3, '2d76600d6cc7b8a76b7cceb64b5d73083ca403ab72ff0f47c1d27182857bf3a33cd4058559f73063e523dca54b10bdc1af4e51119082d82d3e08f36f52e6c4f3RcbC3dNMRdMBT9fnP2KTE3LSa7Sap9+O+CQqhUFy5PM=', '3b703ec1fc32f52e3615b135db7a99b3bec5ae74414c2c559fb2101e12540fd464d570607ebb9793377da1ab55e1207cff6b196a9a87736245fcb6a9154d8f40MMyZ0pT8R8D6DTfRmhw6NRcTqvoIZXToofED4BPNxe4omEYKiDaha2QNScwXQB5i', 'b93cca817950e90d777b2f80ca925cb7a89504fa3333055e84b72aa2b713f0af43c98e35fb8d6a08a8d90e2c7b535cc8ec31bfd997d61cb593bf4bc46fe1e80dZ2m1d3y0SH2ZgcqncVD4bN72t4gqWM5JRDHE+TskcRAVovUWsZu/Rzb1rVKELLWF', '29b66aa168391f621c146b3e5cb156ea7dc57233a64085b213a83dd6070c04e630d3252c188c4292c87a08f5a8dfc7c45ee3ec6aa6fa3aed9286cf2dcb90c5c0zZeHX2H8vzedOSw0R8Us+3n4O/WBTICuUpXUGp+Y1ZeB4xfmuimVR1wGD3oKYt6L', '1493adc5c648003bdc8671bf8bfaadc58a50a3bbfec886b56c620c070d8e6e02e93e71dc649877678017391e0304489d3f6a5ae17a411b91dd633756c6041f06iJ69RNVZfZwdKVRVQ/PxJEvHVNkdLI7fRGhKthv+KFH45jPKagZ/pcpg91+PM6Sa', 'Y', '2023-03-31 16:46:03', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `product_master_deposit` VALUES (4, 'ca54bcc5f90455e438a3db6b7f66842e92d0dbe3142ba018db57c1e94a311b2d4a73ae54bae73aabba0287cac2a7f32b660304e44578ac29d832d24d393961036+Q4bh94/Fku1kBEytOoRdHWe8PvGAEYY9DSqiWxmbg=', 'da9b2d7b94b33ffb9e93610a58a90e303f4907e1fc76eaf6079662fc077b82d744653ae2febc16e4ab8c44fdfa49af4a512b4218a6b107e84c2964f7f47a50eaBUmeufdz4hZlwFdHxqpKSY0YO+53L6YSUbKLYD13mJ0=', 'e0ada6c547a206b58488e8765eda43cfae57858bb68012f8208da813d273cec33c951b4087364aecfb3845ac36eb9f3947465aa68b07eb1226e277bd2a4c4f35qm6r6vV6k/Qo6ppM6p097nEE6IolAjZQuHURgH/MTAw=', '78b43ba869cab21786355fffb94ace74d6fe74b5a41f90e6743b537156b54401044e9e44a7cc1144d5a8886020facfb9d61fdacc860d8e6760bdb75e298f219bfaO7X/ybn4H/bhpEVlYj2tbXnuC+Sb6PAN/Kqzhji1M=', 'a7b4479694c7f3ab5cf77a8dc74300641a13fd23993ebb7ef63b821ff6da7388251850efd14371ef995d1ea00ed9064c085beaadb6c1a9d8a22a6bfe10f15b79pDiZnsxbVQuGltaJFyTWjZtH5YjaWaY3E7xKzXo7LGo=', 'N', '2023-06-13 15:48:53', 4, '2023-06-13 15:49:17', 4);

-- ----------------------------
-- Table structure for product_master_loan
-- ----------------------------
DROP TABLE IF EXISTS `product_master_loan`;
CREATE TABLE `product_master_loan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `loan_type_id` int NULL DEFAULT NULL,
  `loan_type` varchar(525) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `loan_main_product_code` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `loan_main_product_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `loan_sub_product_code` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `loan_sub_product_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `loan_category` enum('G','M','P','O') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'O' COMMENT 'G=Gold, M=Mortgage, P=Personal, O=Others',
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_master_loan
-- ----------------------------
INSERT INTO `product_master_loan` VALUES (1, NULL, 'cd2a2013c877b5321b6a77c2cd7e154fdf5f4ac5824babd45933cb380b59351231743d04a4a71259624c59bed3cac8276ca17945f2a380e685410bdabefe64cf0+wDRh1BheDcK7AJ7ya9p71zW+l2/IQ1s+oQrtjLTlQ=', 'a751406ec284294b6230ec75f70fa8427c946baa51bb459c7582e4d81a40984d486a040e429f96e5584b72481c13f8e5e3a8cd0c51117b0e360831c03ab8747dzEuFXUaAbCxBLAvAt+Sj6Jkm4fXg1Suvz/3RHgR2Vs9fodBpYU8YNg0heIwBiwof', 'ba3d5b930668351c19143b3b8541c7cef0a4e21c4301cf07dd7dcf2c541699358a2170f676425fdca70362359576073eeb9f830cd12dd1cc7f8e265d5aaaeda8zY7bKVFk7eq6qV2Gd9m8pr3KWQ2cBL3PHmvICUXiLBwHaedH/ThXursmwpyYrjQq', 'b2ac457f1ed2fe74f24cdbcbd627835a33fdab8d1ab801e3e1061052d867736adad208d18b9cf3009bf5cf2a02df99bb99a6728d5e7412de598694ea4957118fO6sli1pb09BS8KC813TrloQOes0qYUMeM5vAsAsIm8RkYALny5S4sfL74U3ZCcI8', 'ca422a2354a59a3aa41c29849b5566bc5bd714a8d046e730665cbd4958eaccdff275b442530cc10564b2759458bfcd53369e761f55b45b6e358c636a610fa9c8OM/W39rA/+JkVnbNaBnERpCh4x/efmLr3KZFYs/L8j+CfzGro5MQYvPbF4DsVHne', 'O', 'N', '2023-02-20 20:22:57', 4, '2023-02-20 20:23:38', 4);
INSERT INTO `product_master_loan` VALUES (2, NULL, '2160188f59e6e84ab4d6b3693cd831253bf824485faacbdeddf48f2166058a08de05a13d79527fa7856be205a46084a2a05b914a15da1d669011ef59a28a4913ApM+GhQ6IpXvclpwYNAXVyx4kB7elG33E2nMJPyXaYw=', 'bcc37125f060b65a57fb179512cf26e2b2aa1729f28402bb86047da25c79f4c312a49fd62d231aa100409cb426245558fadd7d88742b2fd390055143cc6fcec1ayRx/OfR5ZVTZFIc36uhdBDdRe0HprCwQxcu/P+4lBaIoq7ZJ8dH/odnj7FVlTZn', '92b4032048b4f15ba268d0cafb2899d89f5a0790fb6cf3d6169e9b80b2725f31dfde188e14a6a4346d2344d8d7f77dd6180f862d5f56c0e026cfc2f00cc935739yaA7yHC3TAUTGVJqN1UQs0LYJMdJk3l/E3KFRY1DYPF67vq3wwtGtAHdwmqrgY2', '931e0dd36e707a9f1d0aa6b4723120ec2738dc622a780384cc617a3730a3eebd50c59d5a5fdd245ff523c0ae2d0625a31a6972b1f82952d559d73aefb3e90a19DuyoQDszi1MqtfXGaPHixhG5mShvV3ZMbdx+oZrTiEA=', 'e2f3ed7c6868694477f838974a5932fbeaa37180bfc56efdfe988bb5ef5b4d8d202cfe49627c57dfee565b217307f44d04c5cd524cdd8182c85e99a70bf2ca5ax8TS2Glx28C2cveqsjNsxajEJJkYjl0ttRFnhFY0P7Y+WOvu5zVNH5bccVDK+vIA', 'O', 'N', '2023-02-21 17:41:34', 4, '2023-02-21 17:41:59', 4);
INSERT INTO `product_master_loan` VALUES (3, NULL, '3c0a32f14825b6d252c7f814bab32fa9f15ea9c6c0f6713169c52c8a64adbccaac8dcf521b53bf7cd1d44db7277894b2e005cb21d20f71d05789bb5ee8eb4a0driocvP/VDvG7HNVX5cTjrFLJgeJC1PlKzCnhW9/qli8=', 'da90025f825e510c7a8f74989f3b05873a8e11c095bfb97159c134fa6eb272ce2985f48030e87735788fba83c7038ab81b08bb2a51f83aa9cb68eff816416ed1prJB+seeDxJtWjnv4QGG2lauYKx08S+c+ZJzGR/fB+lTBXiv9Tzx8qDZvZ3Mb9ya', '079c71db39b1bfcbc1dcd1b4e7d870c6595edd10686b34c50750294ce2f6b236c3d355d0a1800801826ba4ebd70d5101ccec3f1df60399491a9684cdcb79eb0coqfUNkztJLt0yqM1wiwsTbY3+yMeLSZPyoIRjg+cZTzkPIHYIlB1kI2kthgcEBf2', 'dd20b3a1c19214daf25839aefc3215d3759065a51f606c43a27aa9d36f7beca12c3acd038c408dceb5414f107a9003bd5929b4edbea54c61c6d9a130c111d944o7UQd6JdDViVPanThqSz+lGWfkVV2MkeUbRKlNM9LMQ=', '1bb9b5c56135c89859b1271b223d845c7d5f0c882577f1630243ddbc413c3f6e400d0e552854dcdfc68c4405d47fd36b7ef83733018e9be5d6fcd1b9abce2d64C0Rtg3h/QukooV6mn4KFSiPOixAD/iaXxtcdKARFx27pEDKmu9Df+3AHoQQ9vYv4', 'O', 'N', '2023-04-03 21:39:12', 4, NULL, 0);
INSERT INTO `product_master_loan` VALUES (4, NULL, '14e7103d17ca5306d3ff0610115a4c6ba8936668a6299f93e47c308241a1c77713753bf1a9d0d1604542fd4108d04311588529c4115671f889ece9039f94ef49QftkBqN6bqupfsSJo+oTisXKEcZNtFgpXoIJJEUfN64=', '314f8ab1b7f139dc2f65b26e819a607550daea93746075fca2aa3912434eb93e888860b9bd030f7db34e7839d8c69f87f62a3d11600c0ca0b742c9d992cec8318zJNnpw020a6JaY6q3bfRsuTSpkjw4ayRo6iQDGdB3o=', 'f6555f4c7ad89c544fa2aedb1a8fcc0e8599b1d88a8ecf636c96a3212e25549ae898324bb836ae339dfac528ceb540581a7f47f58ee562dc5e4d3b1fe3d2b994PmnUiCvi8MTwAz5FgRCXGhx4RIIc0WCulHesyUac0WA=', '551acfdfb7fe520ca117215d9b9badde287a3b9f87003297569ce5fa0485d274357df5e6725e82d8e4c88a49afc2bf3224d99379e36cdafb878d9e8c198bcfa6MzGEhxgiO39aMLhX1zHLohOBLgl1S1p6kgk70msDrDc=', '4ea76a6993b1557ea3f72578e9cfc49d98b50c774c8dfc6ed3e4af0b33c4ac7cc1e4a8129de232cc688fe46c65633338044cc4eadb8f0d9fd3c746694fabe07b1f3Mc7HrS6NNX4G7NTuljrGNspQpdGWQr+KN+ocHZzQ=', 'O', 'N', '2023-04-24 16:13:15', 4, NULL, 0);
INSERT INTO `product_master_loan` VALUES (5, NULL, '19b28d0d994626d3d0d9bb1bd4d7c8f10ac7d1dca07f7a578f3d61644a29f408447f4ccf4fe881b2d4f970b9a5b49a12e130c069ef54a7925c2fdffbbd9eee7eMjsJrZHECRXhKHCTwzY09f04UVXqDjxDtIwHA+nKwrEC7xM+9KtAGv9hORCJzaM9', 'b8b166e7c7b3e51524d3940622a1811c84980d76a0fcd0b2237199426241f429a7b59b686a213b4aeb2720b9b07a4cfd3bc0c98f535cbf89b06313dfa14f4e38jMXWXDDXf+JQsKnFYS9pCH/bYwlOcYvnWr0VoIQALyQ=', 'ddc0f500c324ce928a9e67e21530f66d25b4fe93c9b94549e4e9d2acf320cf82ee36b46615e74e39e1bb2bf26723c7ad9ebb2153d5207165922e1ad0e3272036blc3H1blUr41yOHwW663gVxj/sBanKP4vn9FBHkydsU=', '6abf17a25168722aaba221ba4d47dad745d2725afb02163e17a692f92b9461f11ec0d894fea09280a1c05108ac659974a8e748fdc8a7f583a674776ae9e0bd84o1la0gegET54cNS7pagyIjUqYjs77IQ6Mp6l644Abgg=', '3652135b7c6388b64f6c73d5f096d8904c2d6bc2d107db8828020c1a2750839a60dce17e5d759281fbb79c287413ee6554d7b1cd72db30f9f17ef0faec73c2545EeBupKpB1VwDdxjxQHcdPGOLLli1Re/BtLmVJjG2dohu+hF6+8+9xnmX3A+zcaYz88thBkBZL9Al0+TCdB/Jg==', 'O', 'Y', '2023-05-23 16:30:32', 4, NULL, 0);
INSERT INTO `product_master_loan` VALUES (6, NULL, '4ac7590d204aecb0866590463bc22d74098005f0e73143728ad81174be7a2bf706154058c1edf66406c1ddcda420759949ec367f8dd22150a547fe44e3e852f0MafG42+nk6BYAZWokm/J5BgN6pj5OZyrfausUzPSboY=', '3ea870048de73d2bf9037c73a7f2b978a2ad2a5880c1fee5e9fb93862b0f1dc498ed1c6bf4bcda8c9636f31779ed24e1398f4143b02549b0145309e78793afc5/u+1xr0+QFhr6twinH6UpjPfuDhCgErjnK+vkcyZPdQ=', '126fac1198c894af72c3aa89567536dcce76698ced9d7870e278a4fe0a4f0886222adce498c02a1f886b8f4e813ce5f46b7daae75289ecc3ef38dcf64900cef5rTTLHlqun0h0SP4OUiluNpd8GIC5x2TnMH3csZ9+808=', 'd56168c45245a5fe11c326e5ec1e320ca5e0a7819705a491351a24cc32d9ad454ba2106feecf827aba65630685495cfc9e3571bb3b15c1439c59b7ec816b912eNONAQ96Z0T+fXH1Ov3dW7/F+3Pgeb8uMbuWzjE/+0gs=', 'c11f5dbff97f4a53363231eb349216e40bc9b48e1c6e9429dde7733c25085014a589cdb352fdb0b62888671f54a2dc770aef24a21c8a960a40ea3b2233f388fdG8sJhILgJs8ClaRL/9QSRWpybPRrIER/t2lrppGwBeY=', 'O', 'N', '2023-06-13 16:58:27', 4, NULL, 0);
INSERT INTO `product_master_loan` VALUES (7, NULL, '9f52574ff7005a173354452aaf294ab13f8248bb099fcc5f81b51f12633794faae23cece774f731874e0717f9839da8bd76cb1147ea1d84b049b4b5c55ef7d31UTzGNFLPOR3CLDt7RVnXG8LVB29FWVqoTpGeRP8HhhwfOjqLSEQ4BRgfEwWyIEZ+', '6d3bc584b36935b0088691c9051189fc126f538103bf1fefc6fb18e9a5e62ad530d5033b26ddecde3369c3d6d8630e60f2850c72d63f576a1b3580812e382efaVHiwFKmB3GFEMl4Kop6egmpZRgEOurw89BgO3Rjmeqo=', '95afeb6a92a5556b1d981528c2034999aa39a6cdca53ae51beb52e011d0e553f8022e504dbb26e853361f150811fda991cb5454c27c8ad5b4a748b0920521ea8MAomv+oFEabxNxwf72H8EehSemILpS5vqB7ZCwtbC44=', 'f44d7dd293ae601c8d8eb690c7787d7a61a34eced096b650b3055f018eaffcaf00e54b26b860fe0eaf2f1af1694cb475bfb0db61319c470db62e263d9bf3f092VhNC4vuv65f2El8ynGxwAaLG5/OpjMudb8OrIx+FZ0Y=', 'e7cfdf908f58ca6dc54eff9bf20fbb11e04a390592e48e17be58db0bba1cc2047205d35f456d19d203535331cf74a297c7baed894d5a0ba6f985b92d69fc6fc8ENz9kim/DhHpKBpandIZPGHK99SAViKhgQKLfJyFha0=', 'O', 'Y', '2023-06-19 10:10:04', 4, NULL, 0);
INSERT INTO `product_master_loan` VALUES (8, NULL, 'a83a3af013919227443bfc2f6709630548378832d14f9032247aa7a590b16fe2c10b68bcb2c299aaeb28d3cea0ac18a2286b90b7a47a42f6b5d9d9a43a8fa50cC6FNFwQIBuOzsXVbu5PNSdEx6OOq487HS8PrbUcUBFaideFR7oMToAaos9jqdL4v', 'a3bc0a0ae23921c2cfab113b697d406745d2f414a59cdd370473da446b026dbbcd4b2e36a3c7bd83ae22e82b035e37da34d48be12c6e2aa36cd488b30475de54Ra89X8mxPh5v/e8HBV2wna1xUWe/cW2H9oNrWamgODs=', '174153e08b0c61e518fb515148103f3ccdb38129af1cf67599cfcceb41fc70c20b05fe586b496e3c9649460201ee7fd4497bd6e3fefee2e41dffb5a3493bec8cTXK1vdKrWLNIcS6i6g2rNc0M7JX789v9FHyv0BiCX4U=', 'f289753aa0460f83516aaa79cbd4582bdfe65798fd59030c2ff214ca0886618585de69ea1d21e2591c5a51cb2d74fc5de6f5abeefe1f5240140b93d7d4b66c76Izd/uMvOqqBJI+H9wPUEQLqelcFaB10Xw7Af7m2kdp0=', '7ec0e80bbbff4953605b9f50cd120e2d0023c4d220f257148b531bb16d19ec5f02f18cc4acd86dcc23303d376ed8c966ca956b414060b07c24d2cf04b969395ekUP4Ivig2PQpqwts7XdwursCX7UfCxMEHt0LvqkjFwY=', 'G', 'Y', '2023-06-19 10:15:49', 4, '2023-08-29 11:29:37', 4);

-- ----------------------------
-- Table structure for product_wise_loan_limits_with_interest_rate
-- ----------------------------
DROP TABLE IF EXISTS `product_wise_loan_limits_with_interest_rate`;
CREATE TABLE `product_wise_loan_limits_with_interest_rate`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_type` int NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `lower_limit` int NULL DEFAULT NULL,
  `upper_limit` int NULL DEFAULT NULL,
  `interest` float NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_wise_loan_limits_with_interest_rate
-- ----------------------------
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (1, NULL, 3, NULL, NULL, NULL, 'N', '2023-04-21 11:52:59', 4, '2023-04-21 11:52:59', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (2, NULL, 3, NULL, NULL, NULL, 'N', '2023-04-21 11:54:41', 4, '2023-04-21 11:54:41', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (3, NULL, 1, NULL, NULL, NULL, 'N', '2023-04-21 13:25:40', 4, '2023-04-21 13:25:40', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (4, NULL, 1, NULL, NULL, NULL, 'N', '2023-04-21 13:26:09', 4, '2023-04-21 13:26:09', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (5, NULL, 1, NULL, NULL, NULL, 'N', '2023-04-21 13:32:56', 4, '2023-04-21 13:32:56', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (6, NULL, 1, NULL, NULL, NULL, 'N', '2023-04-21 13:33:48', 4, '2023-04-21 13:33:48', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (7, NULL, 1, NULL, NULL, NULL, 'N', '2023-04-21 14:34:27', 4, '2023-04-21 14:34:27', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (8, 0, 1, 1000, 2000, 10, 'Y', '2023-04-24 12:42:03', 4, '2023-04-24 12:42:03', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (9, 0, 1, 1000, 2000, 10, 'Y', '2023-04-24 12:42:20', 4, '2023-04-24 12:42:20', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (10, 0, 3, 1000, 2000, 10, 'Y', '2023-04-24 12:43:33', 4, '2023-04-24 13:22:51', 4);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (11, 1, 3, 50000, 100000, 10, 'Y', '2023-04-24 14:10:29', 4, '2023-04-24 08:40:29', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (12, 11, 3, 50000, 500000, 10, 'Y', '2023-06-12 19:28:46', 4, '2023-06-12 13:58:46', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (13, 13, 3, 1000, 100000, 5, 'Y', '2023-06-12 19:29:06', 4, '2023-06-12 13:59:06', NULL);
INSERT INTO `product_wise_loan_limits_with_interest_rate` VALUES (14, 11, 5, 1, 500000, 10, 'Y', '2023-06-21 13:20:48', 4, '2023-06-21 07:50:48', NULL);

-- ----------------------------
-- Table structure for query_builder_create_table_datatype
-- ----------------------------
DROP TABLE IF EXISTS `query_builder_create_table_datatype`;
CREATE TABLE `query_builder_create_table_datatype`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `datatype` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of query_builder_create_table_datatype
-- ----------------------------
INSERT INTO `query_builder_create_table_datatype` VALUES (1, 'INT', 'Y', '2023-07-07 11:23:49', 4, NULL, NULL);
INSERT INTO `query_builder_create_table_datatype` VALUES (2, 'VARCHAR', 'Y', '2023-07-07 11:23:49', 4, NULL, NULL);
INSERT INTO `query_builder_create_table_datatype` VALUES (3, 'TEXT', 'Y', '2023-07-07 11:24:50', 4, NULL, NULL);
INSERT INTO `query_builder_create_table_datatype` VALUES (4, 'DATE', 'Y', '2023-07-07 11:24:50', 4, NULL, NULL);
INSERT INTO `query_builder_create_table_datatype` VALUES (5, 'DATETIME', 'Y', '2023-07-11 12:33:19', 4, NULL, NULL);

-- ----------------------------
-- Table structure for query_builder_field_functions
-- ----------------------------
DROP TABLE IF EXISTS `query_builder_field_functions`;
CREATE TABLE `query_builder_field_functions`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `function_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of query_builder_field_functions
-- ----------------------------
INSERT INTO `query_builder_field_functions` VALUES (1, 'change', 'Y', '2023-07-12 11:50:44', 4, NULL, NULL);
INSERT INTO `query_builder_field_functions` VALUES (2, 'focus', 'Y', '2023-07-12 11:50:44', 4, NULL, NULL);
INSERT INTO `query_builder_field_functions` VALUES (3, 'blur', 'Y', '2023-07-12 11:51:23', 4, NULL, NULL);
INSERT INTO `query_builder_field_functions` VALUES (4, 'abort', 'Y', '2023-07-12 11:51:23', 4, NULL, NULL);
INSERT INTO `query_builder_field_functions` VALUES (5, 'click', 'Y', '2023-07-12 11:53:10', 4, NULL, NULL);
INSERT INTO `query_builder_field_functions` VALUES (6, 'canplay', 'Y', '2023-07-12 11:53:10', 4, NULL, NULL);
INSERT INTO `query_builder_field_functions` VALUES (7, 'load', 'Y', '2023-07-13 13:02:56', 4, NULL, NULL);
INSERT INTO `query_builder_field_functions` VALUES (8, 'ready', 'Y', '2023-07-14 10:17:04', 4, NULL, NULL);

-- ----------------------------
-- Table structure for query_builder_operations
-- ----------------------------
DROP TABLE IF EXISTS `query_builder_operations`;
CREATE TABLE `query_builder_operations`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `operation_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of query_builder_operations
-- ----------------------------
INSERT INTO `query_builder_operations` VALUES (1, 'CREATE TABLE', 'Y', '2023-07-06 14:50:05', 4, NULL, NULL);
INSERT INTO `query_builder_operations` VALUES (2, 'SELECT', 'N', '2023-07-06 14:50:05', 4, NULL, NULL);
INSERT INTO `query_builder_operations` VALUES (3, 'INSERT INTO', 'N', '2023-07-06 14:50:56', 4, '2023-07-06 15:45:43', 4);
INSERT INTO `query_builder_operations` VALUES (4, 'UPDATE', 'N', '2023-07-06 14:50:56', 4, NULL, NULL);
INSERT INTO `query_builder_operations` VALUES (5, 'ALTER TABLE', 'N', '2023-07-06 14:51:41', 4, NULL, NULL);
INSERT INTO `query_builder_operations` VALUES (6, 'DELETE FROM', 'N', '2023-07-06 14:51:41', 4, NULL, NULL);
INSERT INTO `query_builder_operations` VALUES (7, 'TEST', 'N', '2023-07-06 15:46:48', 4, NULL, NULL);

-- ----------------------------
-- Table structure for query_builders
-- ----------------------------
DROP TABLE IF EXISTS `query_builders`;
CREATE TABLE `query_builders`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `operation_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `query_builder_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `query_builder` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of query_builders
-- ----------------------------
INSERT INTO `query_builders` VALUES (3, 'CREATE TABLE', '', '[{\"table_name\":\"test_table\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\"},{\"table_name\":\"test_table\",\"column_name\":\"test_name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":null},{\"table_name\":\"test_table\",\"column_name\":\"created_at\",\"data_type\":\"DATE\",\"length\":\"20\",\"is_null\":null},{\"table_name\":\"test_table\",\"column_name\":\"updated_at\",\"data_type\":\"DATE\",\"length\":\"20\",\"is_null\":null}]', 'N', '2023-07-07 13:41:26', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (6, 'SELECT', '', '[{\"table_name\":\"test_table\"}]', 'N', '2023-07-10 12:14:40', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (7, 'SELECT', '', '[{\"table_name\":\"test_table\",\"where_field_name\":\"test_name\",\"where_field_value\":\"Suhrid Sarkar || suhrid.developer@gmail.com\"}]', 'N', '2023-07-10 12:15:58', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (8, 'CREATE TABLE', '', '[{\"table_name\":\"test_table_2\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\"},{\"table_name\":\"test_table_2\",\"column_name\":\"test_name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"Y\"},{\"table_name\":\"test_table_2\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"10\",\"is_null\":null},{\"table_name\":\"test_table_2\",\"column_name\":\"created_at\",\"data_type\":\"DATE\",\"length\":\"20\",\"is_null\":null},{\"table_name\":\"test_table_2\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":null},{\"table_name\":\"test_table_2\",\"column_name\":\"updated_at\",\"data_type\":\"DATE\",\"length\":\"20\",\"is_null\":null},{\"table_name\":\"test_table_2\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":null}]', 'N', '2023-07-10 12:18:36', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (9, 'CREATE TABLE', '', '[{\"table_name\":\"gender_master\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":null},{\"table_name\":\"gender_master\",\"column_name\":\"field_name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":null},{\"table_name\":\"gender_master\",\"column_name\":\"field_value\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":null},{\"table_name\":\"gender_master\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"7\",\"is_null\":null}]', 'N', '2023-07-11 11:28:38', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (10, 'CREATE TABLE', '', '[{\"table_name\":\"city_master\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\"},{\"table_name\":\"city_master\",\"column_name\":\"city_name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"N\"},{\"table_name\":\"city_master\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"20\",\"is_null\":\"N\"},{\"table_name\":\"city_master\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"N\"},{\"table_name\":\"city_master\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\"},{\"table_name\":\"city_master\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"Y\"},{\"table_name\":\"city_master\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\"}]', 'Y', '2023-07-11 12:42:03', 4, '2023-07-11 12:53:24', 4);
INSERT INTO `query_builders` VALUES (11, 'CREATE TABLE', '', '[{\"table_name\":\"marital_status_master\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"\"},{\"table_name\":\"marital_status_master\",\"column_name\":\"marital_status\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"marital_status_master\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"20\",\"is_null\":\"N\",\"is_show\":\"\"},{\"table_name\":\"marital_status_master\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"N\",\"is_show\":\"\"},{\"table_name\":\"marital_status_master\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"\"},{\"table_name\":\"marital_status_master\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"Y\",\"is_show\":\"\"},{\"table_name\":\"marital_status_master\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"\"},{\"table_name\":\"marital_status_master\",\"column_name\":\"value\",\"data_type\":\"VARCHAR\",\"length\":\"10\",\"is_null\":\"Y\",\"is_show\":\"Y\"}]', 'Y', '2023-07-13 12:42:52', 4, '2023-08-16 18:13:09', 4);
INSERT INTO `query_builders` VALUES (12, 'CREATE TABLE', '', '[{\"table_name\":\"education_qualification\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"education_qualification\",\"column_name\":\"education_qualification\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"education_qualification\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"20\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"education_qualification\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"education_qualification\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"education_qualification\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"Y\",\"is_show\":\"Y\"},{\"table_name\":\"education_qualification\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"Y\"},{\"table_name\":\"education_qualification\",\"column_name\":\"value\",\"data_type\":\"VARCHAR\",\"length\":\"10\",\"is_null\":\"Y\",\"is_show\":\"Y\"}]', 'Y', '2023-07-13 12:49:45', 4, '2023-07-21 12:50:13', 4);
INSERT INTO `query_builders` VALUES (13, 'CREATE TABLE', '', '[{\"table_name\":\"condition_operators\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"condition_operators\",\"column_name\":\"operator\",\"data_type\":\"VARCHAR\",\"length\":\"20\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"condition_operators\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"2\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"condition_operators\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"condition_operators\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"condition_operators\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"Y\",\"is_show\":\"N\"},{\"table_name\":\"condition_operators\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"N\"}]', 'Y', '2023-07-27 16:56:54', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (14, 'CREATE TABLE', '', '[{\"table_name\":\"module_master\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"module_master\",\"column_name\":\"module_name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"module_master\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"2\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"module_master\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"module_master\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"module_master\",\"column_name\":\"uodated_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"Y\",\"is_show\":\"N\"},{\"table_name\":\"module_master\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"N\"}]', 'Y', '2023-07-27 17:03:55', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (15, 'CREATE TABLE', '', '[{\"table_name\":\"if_master\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"if_master\",\"column_name\":\"name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"if_master\",\"column_name\":\"if\",\"data_type\":\"VARCHAR\",\"length\":\"10000\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"if_master\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"2\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"if_master\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"if_master\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"if_master\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"Y\",\"is_show\":\"N\"},{\"table_name\":\"if_master\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"N\"}]', 'Y', '2023-08-16 18:11:13', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (16, 'CREATE TABLE', '', '[{\"table_name\":\"then_master\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"then_master\",\"column_name\":\"name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"then_master\",\"column_name\":\"then\",\"data_type\":\"VARCHAR\",\"length\":\"10000\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"then_master\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"2\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"then_master\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"then_master\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"then_master\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"Y\",\"is_show\":\"N\"},{\"table_name\":\"then_master\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"N\"}]', 'Y', '2023-08-17 12:58:55', 4, NULL, NULL);
INSERT INTO `query_builders` VALUES (17, 'CREATE TABLE', '', '[{\"table_name\":\"Pincode\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"10\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"Pincode\",\"column_name\":\"pincode\",\"data_type\":\"INT\",\"length\":\"6\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"Pincode\",\"column_name\":\"vilage\",\"data_type\":\"VARCHAR\",\"length\":\"50\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"Pincode\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"20\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"Pincode\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"Pincode\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"Pincode\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"20\",\"is_null\":\"Y\",\"is_show\":\"N\"},{\"table_name\":\"Pincode\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"N\"}]', 'Y', '2023-08-24 15:35:32', 4, '2023-08-24 15:36:14', 4);
INSERT INTO `query_builders` VALUES (18, 'CREATE TABLE', '', '[{\"table_name\":\"golddetails\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golddetails\",\"column_name\":\"marketvalue\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"golddetails\",\"column_name\":\"lendingvalue\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"golddetails\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"2\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golddetails\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golddetails\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golddetails\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"Y\",\"is_show\":\"N\"},{\"table_name\":\"golddetails\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"N\"}]', 'Y', '2023-08-31 11:10:58', 4, '2023-08-31 11:11:21', 4);
INSERT INTO `query_builders` VALUES (19, 'CREATE TABLE', '', '[{\"table_name\":\"golditems\",\"column_name\":\"id\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golditems\",\"column_name\":\"item_name\",\"data_type\":\"VARCHAR\",\"length\":\"255\",\"is_null\":\"N\",\"is_show\":\"Y\"},{\"table_name\":\"golditems\",\"column_name\":\"is_active\",\"data_type\":\"VARCHAR\",\"length\":\"2\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golditems\",\"column_name\":\"created_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golditems\",\"column_name\":\"created_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"N\",\"is_show\":\"N\"},{\"table_name\":\"golditems\",\"column_name\":\"updated_at\",\"data_type\":\"DATETIME\",\"length\":\"6\",\"is_null\":\"Y\",\"is_show\":\"N\"},{\"table_name\":\"golditems\",\"column_name\":\"updated_by\",\"data_type\":\"INT\",\"length\":\"11\",\"is_null\":\"Y\",\"is_show\":\"N\"}]', 'Y', '2023-08-31 11:21:01', 4, NULL, NULL);

-- ----------------------------
-- Table structure for rule
-- ----------------------------
DROP TABLE IF EXISTS `rule`;
CREATE TABLE `rule`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `field_name` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rule_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rule_condition` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of rule
-- ----------------------------
INSERT INTO `rule` VALUES (1, 'Loan', 'ad0a5f3f3f59c2e1195ee97dd02ca528427419b67243ed64640f8bcf9932f8abc09f886062227b4abf9a81d12f652d95ca3b5eac9affe76d40f330220a1a74e95Pnhcgup+uoHncsUrdu1vwforxtoxaglAZfZg8QBiC8=', 'Test Rule', '[{\"if\":\"loan_pan.length\",\"operators\":\"<\",\"then\":\"warnMsg(\'PAN number should be 10 char!\');\"}]', 'N', '2023-07-27 11:44:34', 4, NULL, NULL);
INSERT INTO `rule` VALUES (2, 'Loan', 'loan_pan', 'Test Rule', '[{\"if\":\"strlen(loan_pan.value)\",\"operators\":\"<\",\"then\":\"$array = array(\'status\' => \'fail\', \'error\' => \'Pan number should be 10!\', \'message\' => \'\'); $is_true = false;\",\"this\":\"10\"}]', 'Y', '2023-07-27 11:46:06', 4, '2023-08-22 10:27:54', 4);
INSERT INTO `rule` VALUES (3, 'Loan', 'loan_city', 'Test Rule', '[{\"if\":\"loan_city.value\",\"operators\":\"==\",\"then\":\"warnMsg(\'PAN number should be 10 char!\');\"},{\"if\":\"loan_city.value\",\"operators\":\"!=\",\"then\":\"warnMsg(\'PAN number should be 10 char!\');\"}]', 'N', '2023-07-27 11:50:57', 4, NULL, NULL);
INSERT INTO `rule` VALUES (4, 'Loan', 'loan_city', 'test rule', '[{\"if\":\"loan_city.value\",\"operators\":\"<=\",\"then\":\"warnMsg(\'PAN number should be 10 char!\');\",\"this\":\"10\"},{\"if\":\"loan_city.value\",\"operators\":\">=\",\"then\":\"warnMsg(\'PAN number should be 10 char!\');\",\"this\":\"11\"}]', 'N', '2023-07-27 12:21:26', 4, '2023-07-27 15:15:36', 4);

-- ----------------------------
-- Table structure for salary_account_master
-- ----------------------------
DROP TABLE IF EXISTS `salary_account_master`;
CREATE TABLE `salary_account_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_master_id` int NULL DEFAULT NULL,
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `company_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `company_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `company_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of salary_account_master
-- ----------------------------
INSERT INTO `salary_account_master` VALUES (1, 1000000007, '8768ad62c95ee95aca9d62e0707fc32369fbdbbb8f1f3b4b67ebe3190d63c08f4f892ff7c27029ed5eed504948fc1cc8220e3eac277a03c5e5b99a3edb36413bhrT8JUEISznyGguligcDIPq3P1SajeHUZfF73SUB7tM=', '8bd5510f2d015fe0616f809db8113ce15b144c35c5be8f23cb6889b618a2b55ea613c9f606fb03edce25751a76f43e29eaf55cc30d452cda13058a0057ba1237ucBjcgGOWx93XH9WOI259EU9XI4Qvz0nrzhed2/8TkU=', '726bfee2fd1cc1152bedcaa2b6861983b8059eb174efc43b23b5560c81337e48f52a62577636b99b49eac126aa294ac11d95e778372ccb1178b58683c568201bBZuLtTjqFCank3ZCg3syon/X3H+hXIjS8EzY6KbrX8Y=', 'b33d6e15c89153245c81903c0726a3b3c9eab5c5a55afdf95808ac7b13b8998431c543ac00b38b4543d208739afe7d000307cc706950b4f93838a3bdbdca14bfVfM4OEhEsgc0EIhpJ+2yXvoVLT2r+sJiF+BrwQZKQKs=', 'Y', '2023-05-02 17:48:21', 4);

-- ----------------------------
-- Table structure for standard_password_polices_master
-- ----------------------------
DROP TABLE IF EXISTS `standard_password_polices_master`;
CREATE TABLE `standard_password_polices_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `characters` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` date NULL DEFAULT NULL,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` date NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of standard_password_polices_master
-- ----------------------------
INSERT INTO `standard_password_polices_master` VALUES (1, '28053df38a860e55cfef1381b79498cf86d756a6dbe429d551601a6261e47ff6d478ddfbd5310653e5128a46fe1d90ae0fea6bf562f59d1736a09a14b57ce956hv1r6PkxVqwyHXyHPbBNqsea8vuSLphPfsvpuROzZaTJxwpkEJwJhMMe0tRCkJpF', 'b4f0066acc8e0b05176c2ccb5897f2bdcfbeb4ae4eef80bb2f0f66dd5877080fbe7d6594570fb3bfc10d255787239a18b9a2110fc9c8d8790a695d7cfe248c94Zw95XMuQIuf6BR1dF1UEtQQ7dkqtrQOablFlATsZmTA=', 'Y', '2023-04-07', 4, NULL, NULL);
INSERT INTO `standard_password_polices_master` VALUES (2, '61128ed56aaff4b1ef4c43d6e3e79d652956bf74dcf883830eeafaebfa952b454154556589fa2a3fd95e37266023070da5ab2c05733473d7bec6042181fa1279SnlvQFEZoWaswaD2h3AL5X1dawHMCHmDSsoSCrbdj0JLQ23ReODKzp9LECU5dPGr', '22683c3e93cc88f330834f80a571c15adb7082fe25e6c2166a9973b170b1d7371c0e64116df31d34675aeb4709f3738ea5b6df7c97a644c5a88529a6c682c39aIL09By6TQE7YRrWaGwr12TukSd2h9CiTK26T/bzRbzI=', 'Y', '2023-04-07', 4, NULL, NULL);
INSERT INTO `standard_password_polices_master` VALUES (3, '1ef6ba50a237feb44712b2ea7d58ca9f0dc710907527dc8dce22ec9829f1dfe52a412e639b298e583cbaaf312ca98542e5dcb6690f41bf422822651b35b4dadba/sco6egDC6Qzwd60v7GI8es8ZjDfB59s/lwUR2UwdI=', 'bd0a9a4a40f38b172f56194c7c447e65c8aac72292f41207943683cafcad2930fda3476e3f99f1c27a5e6ce19fd928baa6b8997840160e9883a54dbb49759743mhlJbWsFCUANYQCwZGielxR8L3fM4IiyGVmiqtZrDBA=', 'Y', '2023-04-07', 4, NULL, NULL);
INSERT INTO `standard_password_polices_master` VALUES (4, '321e0dc7edd4239c6c299990c6d6302fde28fc5bbc81d74c51d62f1c476b6473d0322cf39fd832b0c1562017414c81e0148b8a6850cb0759f555b65f25fc2e2am7+vqn0TyjU/HGLsYjSIeNZaOKJT+57xGjlBCEH7kvo=', '1321a49c9654b02af7aa87d8819100ed225843eaac669022db17fef0af036abcef6f9ec976889f64259924dbe65f6cb381de5c82abad4759f6ac38bf6a3971caGVuz0tVoGX/6v7bLLkINevPU5tL/rBVp5Q+Kw/gSz8o=', 'Y', '2023-04-07', 4, NULL, NULL);
INSERT INTO `standard_password_polices_master` VALUES (5, 'e1676858ff12143fd87b094e13deff558c9ac1404f20f6d4a4335c1f3ce5dbd2ca519c985c2861f4f67599cf07b7f44974ec6d65341454801d49184f1c1877c0rvp8NAOe9//uj7Y6oPEnoyWvBI2rX5cKzdOTAOoyVMk=', 'b70880400ec5c5cc1b0ba6bbe6adb4f6e60695d79aa9d0198fd7b4feb5076d31408eb904fdb287539b7d9ee534667ea09dd87c4575a4fef90354c5987efa971eQ7ulNVXwdxma1ZqzSWhDULY9dauHaICu+vFF41F4FGk=', 'Y', '2023-04-07', 4, '2023-04-07', 4);

-- ----------------------------
-- Table structure for sub_groups
-- ----------------------------
DROP TABLE IF EXISTS `sub_groups`;
CREATE TABLE `sub_groups`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `sub_group_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `group_id` int NOT NULL,
  `link` varchar(700) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` int NULL DEFAULT NULL,
  `show_on_menu` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `has_action_button` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 38 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sub_groups
-- ----------------------------
INSERT INTO `sub_groups` VALUES (1, 'Branch Master', 3, 'master_settings/branch_master', 0, '1', 'Y', 'Y', '2023-04-05 04:34:07', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (2, 'User Role Master', 3, 'master_settings/user_role_master', 0, '1', 'Y', 'Y', '2023-02-15 17:19:43', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (3, 'User Master', 3, 'master_settings/user_master', 0, '1', 'Y', 'Y', '2023-02-15 17:20:29', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (4, 'User Login History', 4, 'user_logs/user_login_history', 0, '1', 'N', 'Y', '2023-04-03 16:36:08', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (5, 'User Password Changed History', 4, 'user_logs/user_password_change_history', 0, '1', 'N', 'Y', '2023-04-03 16:36:15', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (6, 'User Role Change History', 4, 'user_logs/user_role_change_history', 0, '1', 'N', 'Y', '2023-04-03 16:36:23', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (7, 'User Branch Change History', 4, 'user_logs/user_branch_change_history', 0, '1', 'N', 'Y', '2023-04-03 16:36:29', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (8, 'Assign New Password', 5, 'password_settings/assign_new_password', 0, '1', 'N', 'Y', '2023-04-03 16:36:37', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (9, 'Change Password', 5, 'password_settings/change_password', 0, '1', 'N', 'Y', '2023-04-03 16:36:49', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (10, 'Standard Password Polices Master', 5, 'password_settings/standard_password_polices_master', 0, '1', 'Y', 'Y', '2023-02-15 17:35:13', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (11, 'Product Master (Loans)', 7, 'product_managment/product_master_loan', 0, '1', 'Y', 'Y', '2023-02-15 17:42:37', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (12, 'Product Wise Loan Limits With Interest Rates', 7, 'product_managment/product_wise_loan_limits_with_interest_rate', 0, '1', 'Y', 'Y', '2023-02-15 17:42:37', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (13, 'Product Master (Deposits)', 7, 'product_managment/product_master_deposit', 0, '1', 'Y', 'Y', '2023-02-15 17:43:31', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (14, 'Loan Products', 8, 'user_managment/loan_product', 0, '1', 'Y', 'Y', '2023-02-15 17:46:53', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (15, 'Deposit Products', 8, 'user_managment/deposit_product', 0, '1', 'Y', 'Y', '2023-02-15 17:46:53', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (16, 'Loan Limits Master', 8, 'user_managment/loan_limit_master', 0, '1', 'Y', 'Y', '2023-02-15 17:47:44', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (17, 'Document Master', 3, 'master_settings/document_master', 0, '1', 'Y', 'Y', '2023-04-05 04:30:19', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (18, 'Collateral Master', 3, 'master_settings/collateral_master', 0, '1', 'Y', 'Y', '2023-04-05 04:30:19', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (19, 'De Dupe Master', 3, 'master_settings/de_dupe_master', 0, '1', 'Y', 'Y', '2023-04-05 04:30:19', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (20, 'Co-Applicants / Guarantors / Surety Master', 3, 'master_settings/co_applicant_master', 0, '1', 'Y', 'Y', '2023-05-03 08:10:46', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (21, 'Co-Applicants Panel Master', 3, 'master_settings/co_applicant_panel_master', 20, '1', 'Y', 'Y', '2023-04-12 11:43:25', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (22, 'Other Loan Mester', 3, 'master_settings/other_loan_mester', 20, '1', 'Y', 'Y', '2023-04-12 11:43:25', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (23, 'User Wise Product Master', 7, 'product_managment/user_wise_product_master', 0, '1', 'Y', 'Y', '2023-02-15 17:42:37', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (24, 'Add Applicant', 9, 'add_applicant/customer_master', 0, '1', 'Y', 'Y', '2023-05-23 07:17:52', 1, NULL, NULL);
INSERT INTO `sub_groups` VALUES (25, 'Loan Tab Master', 3, 'master_settings/loan_tab_master', 0, '1', 'Y', 'Y', '2023-05-18 04:51:39', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (26, 'Loan Panel Master', 3, 'master_settings/loan_panel_master', 0, '1', 'Y', 'Y', '2023-05-18 04:51:39', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (27, 'Loan Input Master', 3, 'master_settings/loan_input_master', 0, '1', 'Y', 'Y', '2023-05-18 04:51:39', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (28, 'Workflow and Version Control', 10, 'workflow/workflow_and_version', 0, '1', 'Y', 'Y', '2023-06-05 09:38:35', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (29, 'Pending Loan', 11, 'loan/pending_loan', 0, '1', 'Y', 'Y', '2023-06-07 05:49:59', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (30, 'Approve Loan', 11, 'loan/approve_loan', 0, '1', 'Y', 'Y', '2023-06-07 05:49:59', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (31, 'Rejected Loan', 11, 'loan/rejected_loan', 0, '1', 'Y', 'Y', '2023-06-07 05:50:35', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (32, 'Loan Report', 12, 'report/loan_report', 0, '1', 'Y', 'Y', '2023-06-07 05:50:35', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (33, 'Api Cost Report', 12, 'report/api_report', 0, '1', 'Y', 'Y', '2023-06-09 09:54:56', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (34, 'API Logs', 13, 'api/api_logs', 0, '1', 'Y', 'Y', '2023-06-23 14:18:30', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (35, 'Quary Builder', 14, 'quary_builder/quary_builder', 0, '1', 'Y', 'Y', '2023-05-29 04:51:39', 4, NULL, NULL);
INSERT INTO `sub_groups` VALUES (36, 'Query Builder Operations', 14, 'quary_builder/query_builder_operations', 0, '1', 'Y', 'Y', '2023-07-06 15:27:56', 4, '2023-07-06 15:27:42', 4);
INSERT INTO `sub_groups` VALUES (37, 'Rule', 14, 'quary_builder/rule', 0, '1', 'Y', 'Y', '2023-07-27 11:42:37', 4, NULL, NULL);

-- ----------------------------
-- Table structure for tasks
-- ----------------------------
DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_completed` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'N',
  `is_active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Y',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tasks
-- ----------------------------

-- ----------------------------
-- Table structure for then_master
-- ----------------------------
DROP TABLE IF EXISTS `then_master`;
CREATE TABLE `then_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `then` varchar(10000) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_active` varchar(2) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of then_master
-- ----------------------------
INSERT INTO `then_master` VALUES (1, 'Default Workflow', '$workflow_id = 18;', 'Y', '2023-08-17 12:59:37', 4, NULL, NULL);
INSERT INTO `then_master` VALUES (2, 'Pan Error Message', '$array = array(\'status\' => \'fail\', \'error\' => \'Pan number should be 10!\', \'message\' => \'\'); $is_true = false;', 'Y', '2023-08-17 12:59:54', 4, NULL, NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp_phone` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `otp_phone_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `otp_email` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `otp_email_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, '8fa9d43c2ce8b3974dab9e69397c7fda7464eb4f1314f5ac37b7de5e7bda150f1ff1e180f492f2ab6b1b9f28b61e587707c34695462dba5b1d132edcf6bb77452rUVL8odmaPcRvhbeHJsH2Lqx8O1K8x2WwoudnixOpA=', 'c3385d07d62e11e8647db4c86e5a6e26f5c7c9beeb6abb3d5817dcbdcfe4fee6ca7c38b19cd4e6a10fe854e6834970195ed3667b59639cfc6c8225421c783529o24mCtMx67F+ALHlJGp9niw5AddRyqkWXSonRWMZ3EQ=', 'admin', '2630251742', 'admin', 'N', '8617504622', 'N', 'suhrid@gmail.com', NULL, 'Y', '2023-04-18 15:48:35', NULL, '2023-04-18 10:18:35', NULL);
INSERT INTO `user` VALUES (2, 'aa5979ae969eb45b73e04efe53ca83a3f4b680b7e18b6fe87613b73eeedf187a5457876290c7f7c750eeda169985fe1b1b99cee4a41d1c9b92bd7da39332ca39TGZJy87IMwpGiSt9iy1P4zptGxmHmXHGrYJhziFFO7o=', '3a7908b236a468fc8c2d90af196f010c7485c63d7fef8ab39ee6675073178efccfd1efca2550f05c5ed63e3b6f1fa28f05311d67a3ec6a9d2fc4fca0108ac215cUVncSIXY6r7RnDEfuSAgzpPbvvUP5ZkcSy//mNfGWU=', 'adminnew', '8077913085', 'adminnew', 'N', '7679869125', 'N', 'suhrid05.codegalax@gmail.com', NULL, 'Y', '2023-04-18 15:52:53', NULL, '2023-04-18 10:22:53', NULL);
INSERT INTO `user` VALUES (3, '9dfd4dc9649ad17e05ad868cfdb99bd96b1efd7ab03edcd8ae3d97d2e349e21ef435f308577e6c0fe54546035615a55305cbd36849b4c6ee43be4589eb656132N/+ccUbfjukuaimDDFznjZ7uWF0JWIrISbx0QPIIknQ=', '1cd4c127032e3441d1fdaea2847beaf9df5975d41665dcc26e209b47ed659c7bc2d4b2f94fb61ad6c234bcec7c2158ec1b4aed5259b109236af268655b00a695QSB0qRwI+e60P2jputVuFIpvPIXPkHV3PiHjiTVK8E4=', 'adminn', '8944447188', 'adminn', 'N', '8617504623', 'N', 'suhridsarkar2005@gmail.com', NULL, 'Y', '2023-04-18 15:56:08', NULL, '2023-04-18 10:26:08', NULL);

-- ----------------------------
-- Table structure for user_action_permission
-- ----------------------------
DROP TABLE IF EXISTS `user_action_permission`;
CREATE TABLE `user_action_permission`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL,
  `sub_group_id` int NOT NULL,
  `show_on_menu` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `has_perm` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 197 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_action_permission
-- ----------------------------
INSERT INTO `user_action_permission` VALUES (4, 4, 2, 0, '1', 'Y', 'Y', '2023-02-24 12:41:29', 4, '2023-04-03 21:13:26', 4);
INSERT INTO `user_action_permission` VALUES (5, 4, 3, 0, '1', 'Y', 'Y', '2023-02-24 12:42:11', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (6, 4, 1, 0, '1', 'Y', 'Y', '2023-02-24 12:42:14', 4, '2023-03-15 14:10:18', 4);
INSERT INTO `user_action_permission` VALUES (7, 4, 4, 0, '1', 'Y', 'Y', '2023-02-24 12:42:19', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (8, 4, 5, 0, '1', 'Y', 'Y', '2023-02-24 12:42:27', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (9, 4, 6, 0, '1', 'Y', 'Y', '2023-02-24 12:42:32', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (10, 4, 8, 0, '0', 'N', 'Y', '2023-02-24 12:42:39', 4, '2023-06-21 13:16:34', 4);
INSERT INTO `user_action_permission` VALUES (18, 6, 1, 0, '1', 'Y', 'Y', '2023-03-15 13:54:40', 4, '2023-03-15 15:54:04', 4);
INSERT INTO `user_action_permission` VALUES (19, 6, 2, 0, '1', 'Y', 'Y', '2023-03-15 13:54:43', 4, '2023-03-15 14:38:47', 4);
INSERT INTO `user_action_permission` VALUES (20, 6, 3, 0, '1', 'Y', 'Y', '2023-03-15 13:56:09', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (21, 6, 3, 1, '1', 'Y', 'Y', '2023-03-15 14:04:45', 4, '2023-03-15 15:54:22', 4);
INSERT INTO `user_action_permission` VALUES (22, 4, 3, 1, '1', 'Y', 'Y', '2023-03-15 14:10:25', 4, '2023-03-28 11:00:50', 4);
INSERT INTO `user_action_permission` VALUES (23, 4, 3, 2, '1', 'Y', 'Y', '2023-03-15 14:10:28', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (24, 4, 3, 3, '1', 'Y', 'Y', '2023-03-15 14:10:31', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (25, 4, 4, 4, '1', 'Y', 'Y', '2023-03-15 14:10:35', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (26, 4, 4, 5, '1', 'Y', 'Y', '2023-03-15 14:10:39', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (27, 4, 4, 6, '1', 'Y', 'Y', '2023-03-15 14:10:43', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (28, 4, 4, 7, '1', 'Y', 'Y', '2023-03-15 14:10:47', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (29, 4, 5, 8, '1', 'Y', 'Y', '2023-03-15 14:21:14', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (30, 4, 5, 9, '1', 'Y', 'Y', '2023-03-15 14:21:20', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (31, 4, 5, 10, '1', 'Y', 'Y', '2023-03-15 14:21:24', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (32, 4, 7, 0, '1', 'Y', 'Y', '2023-03-15 14:21:29', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (33, 4, 7, 11, '1', 'Y', 'Y', '2023-03-15 14:21:33', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (34, 4, 7, 12, '1', 'Y', 'Y', '2023-03-15 14:21:38', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (35, 4, 7, 13, '1', 'Y', 'Y', '2023-03-15 14:21:42', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (36, 4, 8, 14, '1', 'Y', 'Y', '2023-03-15 14:21:47', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (37, 4, 8, 15, '1', 'Y', 'Y', '2023-03-15 14:21:54', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (38, 4, 8, 16, '1', 'Y', 'Y', '2023-03-15 14:21:57', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (39, 4, 3, 17, '1', 'Y', 'Y', '2023-04-05 10:13:32', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (40, 4, 3, 18, '1', 'Y', 'Y', '2023-04-10 16:39:19', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (41, 4, 3, 19, '1', 'Y', 'Y', '2023-04-11 14:19:55', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (42, 4, 3, 20, '1', 'Y', 'Y', '2023-04-12 12:18:31', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (43, 4, 3, 21, '1', 'Y', 'Y', '2023-04-12 12:18:36', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (44, 4, 3, 22, '1', 'Y', 'Y', '2023-04-12 15:30:04', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (45, 4, 7, 23, '1', 'Y', 'Y', '2023-04-24 14:09:00', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (46, 4, 3, 24, '1', 'Y', 'Y', '2023-05-02 17:09:48', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (47, 4, 3, 25, '1', 'Y', 'Y', '2023-05-18 10:21:55', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (48, 4, 3, 26, '1', 'Y', 'Y', '2023-05-18 10:21:59', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (49, 4, 3, 27, '1', 'Y', 'Y', '2023-05-19 20:43:17', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (50, 4, 9, 0, '1', 'Y', 'Y', '2023-05-23 12:44:12', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (51, 4, 9, 24, '1', 'Y', 'Y', '2023-05-23 12:44:16', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (52, 4, 10, 0, '1', 'Y', 'Y', '2023-06-05 15:09:21', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (53, 4, 10, 28, '1', 'Y', 'Y', '2023-06-05 15:09:25', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (54, 4, 11, 0, '1', 'Y', 'Y', '2023-06-07 11:20:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (55, 4, 11, 29, '1', 'Y', 'Y', '2023-06-07 11:20:59', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (56, 4, 11, 30, '1', 'Y', 'Y', '2023-06-07 11:21:04', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (57, 4, 11, 31, '1', 'Y', 'Y', '2023-06-07 11:21:09', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (58, 6, 11, 0, '1', 'Y', 'Y', '2023-06-07 15:36:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (59, 6, 11, 29, '1', 'Y', 'Y', '2023-06-07 15:36:55', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (60, 6, 11, 30, '1', 'Y', 'Y', '2023-06-07 15:36:59', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (61, 4, 12, 0, '1', 'Y', 'Y', '2023-06-07 18:31:50', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (62, 4, 12, 32, '1', 'Y', 'Y', '2023-06-07 18:33:30', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (63, 9, 1, 0, '1', 'Y', 'Y', '2023-06-07 19:39:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (64, 9, 11, 29, '1', 'Y', 'Y', '2023-06-07 19:40:03', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (65, 9, 11, 30, '1', 'Y', 'Y', '2023-06-07 19:40:07', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (66, 9, 11, 31, '1', 'Y', 'Y', '2023-06-07 19:40:12', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (67, 8, 1, 0, '1', 'Y', 'Y', '2023-06-07 19:40:58', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (68, 8, 11, 29, '1', 'Y', 'Y', '2023-06-07 19:41:02', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (69, 8, 11, 30, '1', 'Y', 'Y', '2023-06-07 19:41:27', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (70, 8, 11, 31, '1', 'Y', 'Y', '2023-06-07 19:41:32', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (71, 7, 1, 0, '1', 'Y', 'Y', '2023-06-07 19:43:39', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (72, 7, 11, 29, '1', 'Y', 'Y', '2023-06-07 19:43:44', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (73, 7, 11, 30, '1', 'Y', 'Y', '2023-06-07 19:43:48', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (74, 7, 11, 31, '1', 'Y', 'Y', '2023-06-07 19:43:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (75, 4, 12, 33, '1', 'Y', 'Y', '2023-06-09 15:25:09', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (76, 11, 11, 0, '1', 'Y', 'Y', '2023-06-19 10:01:25', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (77, 11, 11, 30, '1', 'Y', 'Y', '2023-06-19 10:01:32', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (78, 11, 11, 29, '1', 'Y', 'Y', '2023-06-19 10:01:36', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (79, 11, 12, 0, '1', 'Y', 'Y', '2023-06-19 10:01:42', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (80, 11, 12, 32, '1', 'Y', 'Y', '2023-06-19 10:01:47', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (81, 11, 11, 31, '1', 'Y', 'Y', '2023-06-19 10:01:59', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (82, 11, 12, 33, '1', 'Y', 'Y', '2023-06-19 10:02:04', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (83, 11, 9, 0, '1', 'Y', 'Y', '2023-06-19 10:02:11', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (84, 11, 9, 24, '1', 'Y', 'Y', '2023-06-19 10:02:17', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (85, 13, 1, 0, '1', 'Y', 'Y', '2023-06-21 10:20:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (86, 13, 5, 0, '1', 'Y', 'Y', '2023-06-21 10:21:01', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (87, 13, 5, 9, '1', 'Y', 'Y', '2023-06-21 10:21:07', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (88, 13, 9, 0, '1', 'Y', 'Y', '2023-06-21 10:21:20', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (89, 13, 9, 24, '1', 'Y', 'Y', '2023-06-21 10:21:34', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (90, 13, 11, 0, '1', 'Y', 'Y', '2023-06-21 10:22:23', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (91, 13, 11, 29, '1', 'Y', 'Y', '2023-06-21 10:22:37', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (92, 13, 11, 30, '1', 'Y', 'Y', '2023-06-21 10:22:48', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (93, 13, 11, 31, '1', 'Y', 'Y', '2023-06-21 10:23:08', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (94, 13, 12, 0, '1', 'Y', 'Y', '2023-06-21 10:23:21', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (95, 13, 12, 32, '1', 'Y', 'Y', '2023-06-21 10:23:33', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (96, 13, 12, 33, '1', 'Y', 'Y', '2023-06-21 10:23:44', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (97, 14, 1, 0, '1', 'Y', 'Y', '2023-06-21 10:34:27', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (98, 14, 5, 0, '1', 'Y', 'Y', '2023-06-21 10:34:46', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (99, 14, 5, 9, '1', 'Y', 'Y', '2023-06-21 10:34:57', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (100, 14, 11, 0, '1', 'Y', 'Y', '2023-06-21 10:35:16', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (101, 14, 9, 0, '1', 'Y', 'Y', '2023-06-21 10:35:55', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (102, 14, 9, 24, '1', 'Y', 'Y', '2023-06-21 10:36:13', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (103, 14, 11, 29, '1', 'Y', 'Y', '2023-06-21 10:36:23', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (104, 14, 11, 30, '1', 'Y', 'Y', '2023-06-21 10:36:38', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (105, 14, 11, 31, '1', 'Y', 'Y', '2023-06-21 10:36:47', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (106, 14, 12, 0, '1', 'Y', 'Y', '2023-06-21 10:36:57', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (107, 14, 12, 32, '1', 'Y', 'Y', '2023-06-21 10:37:06', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (108, 14, 12, 33, '1', 'Y', 'Y', '2023-06-21 10:37:15', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (109, 15, 1, 0, '1', 'Y', 'Y', '2023-06-21 10:44:46', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (110, 15, 5, 0, '1', 'Y', 'Y', '2023-06-21 10:45:04', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (111, 15, 5, 9, '1', 'Y', 'Y', '2023-06-21 10:45:18', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (112, 15, 9, 0, '1', 'Y', 'Y', '2023-06-21 10:45:36', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (113, 15, 9, 24, '1', 'Y', 'Y', '2023-06-21 10:45:47', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (114, 15, 11, 0, '1', 'Y', 'Y', '2023-06-21 10:46:06', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (115, 15, 11, 29, '1', 'Y', 'Y', '2023-06-21 10:46:15', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (116, 15, 11, 30, '1', 'Y', 'Y', '2023-06-21 10:46:25', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (117, 15, 11, 31, '1', 'Y', 'Y', '2023-06-21 10:46:37', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (118, 15, 12, 0, '1', 'Y', 'Y', '2023-06-21 10:46:47', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (119, 15, 12, 32, '1', 'Y', 'Y', '2023-06-21 10:46:56', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (120, 15, 12, 33, '1', 'Y', 'Y', '2023-06-21 10:47:04', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (121, 16, 1, 0, '1', 'Y', 'Y', '2023-06-21 10:53:40', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (122, 16, 5, 0, '1', 'Y', 'Y', '2023-06-21 10:53:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (123, 16, 5, 9, '1', 'Y', 'Y', '2023-06-21 10:53:59', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (124, 16, 9, 0, '1', 'Y', 'Y', '2023-06-21 10:54:14', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (125, 16, 9, 24, '1', 'Y', 'Y', '2023-06-21 10:54:22', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (126, 16, 11, 0, '1', 'Y', 'Y', '2023-06-21 10:54:36', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (127, 16, 11, 29, '1', 'Y', 'Y', '2023-06-21 10:54:45', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (128, 16, 11, 30, '1', 'Y', 'Y', '2023-06-21 10:54:55', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (129, 16, 11, 31, '1', 'Y', 'Y', '2023-06-21 10:55:05', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (130, 16, 12, 0, '1', 'Y', 'Y', '2023-06-21 10:55:17', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (131, 16, 12, 32, '1', 'Y', 'Y', '2023-06-21 10:55:26', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (132, 16, 12, 33, '1', 'Y', 'Y', '2023-06-21 10:55:37', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (133, 17, 1, 0, '1', 'Y', 'Y', '2023-06-21 10:56:26', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (134, 17, 5, 0, '1', 'Y', 'Y', '2023-06-21 10:56:39', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (135, 17, 5, 9, '1', 'Y', 'Y', '2023-06-21 10:56:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (136, 17, 9, 0, '1', 'Y', 'Y', '2023-06-21 10:57:03', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (137, 17, 9, 24, '1', 'Y', 'Y', '2023-06-21 10:57:12', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (138, 17, 11, 0, '1', 'Y', 'Y', '2023-06-21 10:57:26', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (139, 17, 11, 29, '1', 'Y', 'Y', '2023-06-21 10:57:36', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (140, 17, 11, 30, '1', 'Y', 'Y', '2023-06-21 10:57:44', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (141, 17, 11, 31, '1', 'Y', 'Y', '2023-06-21 10:57:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (142, 17, 12, 0, '1', 'Y', 'Y', '2023-06-21 10:57:59', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (143, 17, 12, 32, '1', 'Y', 'Y', '2023-06-21 10:58:07', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (144, 17, 12, 33, '1', 'Y', 'Y', '2023-06-21 10:58:17', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (145, 12, 1, 0, '1', 'Y', 'Y', '2023-06-21 10:58:54', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (146, 12, 5, 0, '1', 'Y', 'Y', '2023-06-21 10:59:06', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (147, 12, 5, 9, '1', 'Y', 'Y', '2023-06-21 10:59:15', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (148, 12, 9, 0, '1', 'Y', 'Y', '2023-06-21 10:59:28', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (149, 12, 9, 24, '1', 'Y', 'Y', '2023-06-21 10:59:41', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (150, 12, 11, 0, '1', 'Y', 'Y', '2023-06-21 10:59:53', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (151, 12, 11, 29, '1', 'Y', 'Y', '2023-06-21 11:00:03', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (152, 12, 11, 30, '1', 'Y', 'Y', '2023-06-21 11:00:12', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (153, 12, 11, 31, '1', 'Y', 'Y', '2023-06-21 11:00:21', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (154, 12, 12, 0, '1', 'Y', 'Y', '2023-06-21 11:00:29', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (155, 12, 12, 32, '1', 'Y', 'Y', '2023-06-21 11:00:37', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (156, 12, 12, 33, '1', 'Y', 'Y', '2023-06-21 11:00:45', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (157, 19, 1, 0, '1', 'Y', 'Y', '2023-06-21 11:01:42', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (158, 19, 5, 0, '1', 'Y', 'Y', '2023-06-21 11:01:53', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (159, 19, 5, 9, '1', 'Y', 'Y', '2023-06-21 11:02:02', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (160, 19, 9, 0, '1', 'Y', 'Y', '2023-06-21 11:02:14', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (161, 19, 9, 24, '1', 'Y', 'Y', '2023-06-21 11:02:22', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (162, 19, 11, 0, '1', 'Y', 'Y', '2023-06-21 11:02:33', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (163, 19, 11, 29, '1', 'Y', 'Y', '2023-06-21 11:02:44', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (164, 19, 11, 30, '1', 'Y', 'Y', '2023-06-21 11:02:54', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (165, 19, 11, 31, '1', 'Y', 'Y', '2023-06-21 11:03:02', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (166, 19, 12, 0, '1', 'Y', 'Y', '2023-06-21 11:03:11', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (167, 19, 12, 32, '1', 'Y', 'Y', '2023-06-21 11:03:19', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (168, 19, 12, 33, '1', 'Y', 'Y', '2023-06-21 11:03:28', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (169, 18, 1, 0, '1', 'Y', 'Y', '2023-06-21 11:04:07', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (170, 18, 5, 0, '1', 'Y', 'Y', '2023-06-21 11:04:17', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (171, 18, 5, 9, '1', 'Y', 'Y', '2023-06-21 11:04:29', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (172, 18, 9, 0, '1', 'Y', 'Y', '2023-06-21 11:04:50', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (173, 18, 9, 24, '1', 'Y', 'Y', '2023-06-21 11:05:01', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (174, 18, 11, 0, '1', 'Y', 'Y', '2023-06-21 11:05:14', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (175, 18, 11, 29, '1', 'Y', 'Y', '2023-06-21 11:05:23', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (176, 18, 11, 30, '1', 'Y', 'Y', '2023-06-21 11:05:31', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (177, 18, 11, 31, '1', 'Y', 'Y', '2023-06-21 11:05:46', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (178, 18, 12, 0, '1', 'Y', 'Y', '2023-06-21 11:05:53', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (179, 18, 12, 32, '1', 'Y', 'Y', '2023-06-21 11:06:03', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (180, 18, 12, 33, '1', 'Y', 'Y', '2023-06-21 11:06:11', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (181, 11, 1, 0, '1', 'Y', 'Y', '2023-06-21 11:06:31', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (182, 11, 5, 0, '1', 'Y', 'Y', '2023-06-21 11:06:40', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (183, 11, 5, 9, '1', 'Y', 'Y', '2023-06-21 11:06:51', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (184, 20, 1, 0, '1', 'Y', 'Y', '2023-06-21 11:33:36', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (185, 20, 5, 0, '1', 'Y', 'Y', '2023-06-21 11:33:45', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (186, 20, 5, 9, '1', 'Y', 'Y', '2023-06-21 11:33:53', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (187, 21, 1, 0, '1', 'Y', 'Y', '2023-06-22 15:38:50', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (188, 21, 11, 0, '1', 'Y', 'Y', '2023-06-22 15:38:59', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (189, 21, 11, 29, '1', 'Y', 'Y', '2023-06-22 15:39:08', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (190, 4, 13, 0, '1', 'Y', 'Y', '2023-06-23 19:46:45', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (191, 4, 13, 34, '1', 'Y', 'Y', '2023-06-23 19:47:33', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (192, 21, 2, 0, '1', 'Y', 'Y', '2023-06-23 21:39:31', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (193, 4, 14, 0, '1', 'Y', 'Y', '2023-06-29 10:06:21', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (194, 4, 14, 35, '1', 'Y', 'Y', '2023-06-29 10:06:26', 4, '0000-00-00 00:00:00', 0);
INSERT INTO `user_action_permission` VALUES (195, 4, 14, 36, '0', 'N', 'Y', '2023-07-06 15:25:03', 4, '2023-07-06 20:01:30', 4);
INSERT INTO `user_action_permission` VALUES (196, 4, 14, 37, '1', 'Y', 'Y', '2023-07-27 17:12:56', 4, '0000-00-00 00:00:00', 0);

-- ----------------------------
-- Table structure for user_action_permission_action
-- ----------------------------
DROP TABLE IF EXISTS `user_action_permission_action`;
CREATE TABLE `user_action_permission_action`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_action_permission_id` int NOT NULL,
  `action_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `has_perm` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 169 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_action_permission_action
-- ----------------------------
INSERT INTO `user_action_permission_action` VALUES (1, 21, 'Add', 'Y', 'Y', 4, '2023-03-15 19:29:32', '2023-03-15 20:01:32', 4);
INSERT INTO `user_action_permission_action` VALUES (2, 21, 'View', 'Y', 'Y', 4, '2023-03-15 20:14:59', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (3, 22, 'Add', 'Y', 'Y', 4, '2023-03-24 15:14:08', '2023-03-28 11:01:13', 4);
INSERT INTO `user_action_permission_action` VALUES (4, 22, 'View', 'Y', 'Y', 4, '2023-03-24 15:14:19', '2023-03-28 11:01:23', 4);
INSERT INTO `user_action_permission_action` VALUES (5, 4, 'Edit', 'Y', 'Y', 4, '2023-04-03 21:12:49', '2023-04-03 21:13:06', 4);
INSERT INTO `user_action_permission_action` VALUES (6, 23, 'Add', 'Y', 'Y', 4, '2023-04-03 21:14:52', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (7, 23, 'View', 'Y', 'Y', 4, '2023-04-03 21:14:56', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (8, 23, 'Edit', 'Y', 'Y', 4, '2023-04-03 21:15:00', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (9, 23, 'Delete', 'Y', 'Y', 4, '2023-04-03 21:15:05', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (10, 22, 'Edit', 'Y', 'Y', 4, '2023-04-03 21:15:16', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (11, 22, 'Delete', 'Y', 'Y', 4, '2023-04-03 21:15:31', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (12, 4, 'Add', 'Y', 'Y', 4, '2023-04-03 21:16:05', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (13, 4, 'View', 'Y', 'Y', 4, '2023-04-03 21:16:12', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (14, 4, 'Delete', 'Y', 'Y', 4, '2023-04-03 21:16:16', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (15, 35, 'Add', 'Y', 'Y', 4, '2023-04-03 21:59:47', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (16, 35, 'View', 'Y', 'Y', 4, '2023-04-03 22:00:35', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (17, 35, 'Delete', 'Y', 'Y', 4, '2023-04-03 22:00:40', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (18, 35, 'Edit', 'Y', 'Y', 4, '2023-04-03 22:01:09', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (19, 33, 'Add', 'Y', 'Y', 4, '2023-04-03 22:01:23', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (20, 33, 'View', 'Y', 'Y', 4, '2023-04-03 22:01:29', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (21, 33, 'Edit', 'Y', 'Y', 4, '2023-04-03 22:01:34', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (22, 33, 'Delete', 'Y', 'Y', 4, '2023-04-03 22:01:38', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (23, 25, 'Add', 'Y', 'Y', 4, '2023-04-03 22:01:48', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (24, 25, 'View', 'Y', 'Y', 4, '2023-04-03 22:01:53', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (25, 25, 'Edit', 'Y', 'Y', 4, '2023-04-03 22:01:58', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (26, 25, 'Delete', 'Y', 'Y', 4, '2023-04-03 22:02:02', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (27, 29, 'Add', 'Y', 'Y', 4, '2023-04-03 22:02:23', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (28, 29, 'View', 'Y', 'Y', 4, '2023-04-03 22:02:28', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (29, 29, 'Edit', 'Y', 'Y', 4, '2023-04-03 22:02:32', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (30, 29, 'Delete', 'Y', 'Y', 4, '2023-04-03 22:02:36', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (31, 30, 'Add', 'Y', 'Y', 4, '2023-04-03 22:02:41', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (32, 30, 'View', 'Y', 'Y', 4, '2023-04-03 22:02:48', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (33, 30, 'Edit', 'Y', 'Y', 4, '2023-04-03 22:02:52', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (34, 30, 'Delete', 'Y', 'Y', 4, '2023-04-03 22:02:57', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (35, 39, 'Add', 'Y', 'Y', 4, '2023-04-05 12:09:13', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (36, 39, 'View', 'Y', 'Y', 4, '2023-04-05 12:09:19', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (37, 39, 'Edit', 'Y', 'Y', 4, '2023-04-05 12:09:22', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (38, 39, 'Delete', 'Y', 'Y', 4, '2023-04-05 12:09:25', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (39, 31, 'Add', 'Y', 'Y', 4, '2023-04-07 14:12:30', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (40, 31, 'View', 'Y', 'Y', 4, '2023-04-07 14:12:34', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (41, 31, 'Edit', 'Y', 'Y', 4, '2023-04-07 14:12:38', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (42, 31, 'Delete', 'Y', 'Y', 4, '2023-04-07 14:12:42', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (43, 24, 'Add', 'Y', 'Y', 4, '2023-04-07 14:15:44', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (44, 24, 'View', 'Y', 'Y', 4, '2023-04-07 14:15:47', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (45, 24, 'Edit', 'Y', 'Y', 4, '2023-04-07 14:15:53', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (46, 40, 'Add', 'Y', 'Y', 4, '2023-04-10 16:39:23', '2023-04-12 12:51:20', 4);
INSERT INTO `user_action_permission_action` VALUES (47, 40, 'View', 'Y', 'Y', 4, '2023-04-10 16:42:15', '2023-04-12 12:51:22', 4);
INSERT INTO `user_action_permission_action` VALUES (48, 40, 'Edit', 'Y', 'Y', 4, '2023-04-10 16:42:18', '2023-04-12 12:51:26', 4);
INSERT INTO `user_action_permission_action` VALUES (49, 40, 'Delete', 'Y', 'Y', 4, '2023-04-10 16:42:22', '2023-04-12 12:51:30', 4);
INSERT INTO `user_action_permission_action` VALUES (50, 24, 'Delete', 'Y', 'Y', 4, '2023-04-11 09:31:54', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (51, 41, 'Add', 'Y', 'Y', 4, '2023-04-11 14:20:16', '2023-04-12 12:51:34', 4);
INSERT INTO `user_action_permission_action` VALUES (52, 41, 'View', 'Y', 'Y', 4, '2023-04-11 14:20:22', '2023-04-12 12:51:37', 4);
INSERT INTO `user_action_permission_action` VALUES (53, 41, 'Edit', 'Y', 'Y', 4, '2023-04-11 14:20:25', '2023-04-12 12:51:44', 4);
INSERT INTO `user_action_permission_action` VALUES (54, 41, 'Delete', 'Y', 'Y', 4, '2023-04-11 14:22:56', '2023-04-12 12:51:47', 4);
INSERT INTO `user_action_permission_action` VALUES (55, 43, 'Add', 'N', 'Y', 4, '2023-04-12 12:18:40', '2023-04-14 14:54:27', 4);
INSERT INTO `user_action_permission_action` VALUES (56, 43, 'View', 'Y', 'Y', 4, '2023-04-12 12:18:43', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (57, 43, 'Edit', 'Y', 'Y', 4, '2023-04-12 12:18:47', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (58, 42, 'Add', 'Y', 'Y', 4, '2023-04-12 15:30:22', '2023-04-13 11:46:28', 4);
INSERT INTO `user_action_permission_action` VALUES (59, 44, 'Add', 'Y', 'Y', 4, '2023-04-12 15:30:42', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (60, 44, 'View', 'Y', 'Y', 4, '2023-04-12 15:30:48', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (61, 44, 'Edit', 'Y', 'Y', 4, '2023-04-12 15:30:50', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (62, 44, 'Delete', 'Y', 'Y', 4, '2023-04-12 15:30:53', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (63, 42, 'View', 'Y', 'Y', 4, '2023-04-13 11:46:35', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (64, 42, 'Edit', 'Y', 'Y', 4, '2023-04-13 11:46:40', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (65, 43, 'Delete', 'N', 'Y', 4, '2023-04-14 14:53:48', '2023-04-14 14:54:21', 4);
INSERT INTO `user_action_permission_action` VALUES (66, 34, 'Add', 'Y', 'Y', 4, '2023-04-20 16:20:55', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (67, 34, 'View', 'Y', 'Y', 4, '2023-04-21 14:50:14', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (68, 34, 'Edit', 'Y', 'Y', 4, '2023-04-21 14:50:18', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (69, 34, 'Delete', 'Y', 'Y', 4, '2023-04-21 14:50:24', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (70, 45, 'Add', 'Y', 'Y', 4, '2023-04-24 14:09:05', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (71, 45, 'View', 'Y', 'Y', 4, '2023-04-24 14:09:33', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (72, 45, 'Edit', 'Y', 'Y', 4, '2023-04-24 14:09:37', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (73, 45, 'Delete', 'Y', 'Y', 4, '2023-04-24 14:09:44', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (74, 46, 'Add', 'Y', 'Y', 4, '2023-05-02 17:09:52', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (75, 46, 'View', 'Y', 'Y', 4, '2023-05-02 17:10:06', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (76, 46, 'Edit', 'Y', 'Y', 4, '2023-05-02 17:10:09', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (77, 46, 'Delete', 'Y', 'Y', 4, '2023-05-02 17:10:13', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (78, 42, 'Delete', 'N', 'Y', 4, '2023-05-08 13:14:19', '2023-05-08 13:16:38', 4);
INSERT INTO `user_action_permission_action` VALUES (79, 47, 'Add', 'Y', 'Y', 4, '2023-05-18 10:22:03', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (80, 47, 'View', 'Y', 'Y', 4, '2023-05-18 10:22:08', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (81, 47, 'Edit', 'Y', 'Y', 4, '2023-05-18 10:22:12', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (82, 48, 'Add', 'Y', 'Y', 4, '2023-05-18 10:22:16', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (83, 48, 'View', 'Y', 'Y', 4, '2023-05-18 10:22:21', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (84, 48, 'Edit', 'Y', 'Y', 4, '2023-05-18 10:22:25', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (85, 49, 'Add', 'Y', 'Y', 4, '2023-05-19 20:43:24', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (86, 49, 'View', 'Y', 'Y', 4, '2023-05-19 20:43:28', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (87, 49, 'Edit', 'Y', 'Y', 4, '2023-05-19 20:43:39', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (88, 49, 'Delete', 'Y', 'Y', 4, '2023-05-19 20:43:44', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (89, 51, 'Add', 'Y', 'Y', 4, '2023-05-23 12:44:20', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (90, 51, 'View', 'Y', 'Y', 4, '2023-05-23 12:50:17', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (91, 51, 'Edit', 'Y', 'Y', 4, '2023-05-23 12:50:21', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (92, 51, 'Delete', 'Y', 'Y', 4, '2023-05-23 12:50:25', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (93, 47, 'Delete', 'Y', 'Y', 4, '2023-05-23 16:25:58', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (94, 53, 'Add', 'Y', 'Y', 4, '2023-06-05 15:09:30', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (95, 53, 'View', 'Y', 'Y', 4, '2023-06-05 15:09:35', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (96, 53, 'Delete', 'Y', 'Y', 4, '2023-06-05 15:09:40', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (97, 55, 'View', 'Y', 'Y', 4, '2023-06-07 11:21:16', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (98, 56, 'View', 'Y', 'Y', 4, '2023-06-07 11:21:21', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (99, 57, 'View', 'Y', 'Y', 4, '2023-06-07 11:21:27', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (100, 59, 'Add', 'Y', 'Y', 4, '2023-06-07 15:37:04', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (101, 59, 'View', 'Y', 'Y', 4, '2023-06-07 15:37:09', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (102, 59, 'Edit', 'Y', 'Y', 4, '2023-06-07 15:37:13', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (103, 59, 'Delete', 'Y', 'Y', 4, '2023-06-07 15:37:18', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (104, 62, 'Add', 'Y', 'Y', 4, '2023-06-07 18:33:33', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (105, 62, 'View', 'Y', 'Y', 4, '2023-06-07 18:33:38', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (106, 62, 'Edit', 'Y', 'Y', 4, '2023-06-07 18:33:42', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (107, 62, 'Delete', 'Y', 'Y', 4, '2023-06-07 18:33:49', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (108, 64, 'View', 'Y', 'Y', 4, '2023-06-07 19:40:16', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (109, 65, 'View', 'Y', 'Y', 4, '2023-06-07 19:40:19', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (110, 66, 'View', 'Y', 'Y', 4, '2023-06-07 19:40:23', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (111, 68, 'View', 'Y', 'Y', 4, '2023-06-07 19:41:37', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (112, 69, 'View', 'Y', 'Y', 4, '2023-06-07 19:41:41', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (113, 70, 'View', 'Y', 'Y', 4, '2023-06-07 19:41:45', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (114, 72, 'View', 'Y', 'Y', 4, '2023-06-07 19:43:55', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (115, 73, 'View', 'Y', 'Y', 4, '2023-06-07 19:43:59', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (116, 74, 'View', 'Y', 'Y', 4, '2023-06-07 19:44:03', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (117, 53, 'Edit', 'Y', 'Y', 4, '2023-06-13 15:20:21', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (118, 89, 'Add', 'Y', 'Y', 4, '2023-06-21 10:21:41', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (119, 89, 'View', 'Y', 'Y', 4, '2023-06-21 10:21:47', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (120, 89, 'Edit', 'Y', 'Y', 4, '2023-06-21 10:21:57', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (121, 175, 'View', 'Y', 'Y', 4, '2023-06-21 13:46:14', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (122, 176, 'View', 'Y', 'Y', 4, '2023-06-21 13:46:22', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (123, 177, 'View', 'Y', 'Y', 4, '2023-06-21 13:46:27', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (124, 161, 'Add', 'Y', 'Y', 4, '2023-06-21 16:36:11', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (125, 163, 'View', 'Y', 'Y', 4, '2023-06-21 16:36:20', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (126, 163, 'Add', 'Y', 'Y', 4, '2023-06-21 16:36:25', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (127, 163, 'Edit', 'Y', 'Y', 4, '2023-06-21 16:36:32', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (128, 173, 'Add', 'Y', 'Y', 4, '2023-06-21 16:38:21', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (129, 173, 'View', 'Y', 'Y', 4, '2023-06-21 16:38:26', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (130, 173, 'Edit', 'Y', 'Y', 4, '2023-06-21 16:38:33', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (131, 175, 'Add', 'Y', 'Y', 4, '2023-06-21 16:38:44', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (132, 176, 'Add', 'Y', 'Y', 4, '2023-06-21 16:38:48', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (133, 177, 'Add', 'Y', 'Y', 4, '2023-06-21 16:38:52', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (134, 175, 'Edit', 'Y', 'Y', 4, '2023-06-21 16:38:55', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (135, 176, 'Edit', 'Y', 'Y', 4, '2023-06-21 16:38:59', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (136, 177, 'Edit', 'Y', 'Y', 4, '2023-06-21 16:39:08', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (137, 56, 'Add', 'Y', 'Y', 4, '2023-06-21 21:31:30', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (138, 57, 'Add', 'Y', 'Y', 4, '2023-06-21 21:31:43', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (139, 55, 'Add', 'Y', 'Y', 4, '2023-06-21 21:31:48', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (140, 55, 'Edit', 'Y', 'Y', 4, '2023-06-21 21:31:53', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (141, 56, 'Edit', 'Y', 'Y', 4, '2023-06-21 21:31:59', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (142, 57, 'Edit', 'Y', 'Y', 4, '2023-06-21 21:32:04', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (143, 55, 'Delete', 'Y', 'Y', 4, '2023-06-21 21:32:46', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (144, 56, 'Delete', 'Y', 'Y', 4, '2023-06-21 21:32:51', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (145, 57, 'Delete', 'Y', 'Y', 4, '2023-06-21 21:32:57', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (146, 189, 'Add', 'Y', 'Y', 4, '2023-06-22 15:39:12', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (147, 84, 'Add', 'Y', 'Y', 4, '2023-06-23 10:44:10', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (148, 84, 'View', 'Y', 'Y', 4, '2023-06-23 11:02:30', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (149, 84, 'Edit', 'Y', 'Y', 4, '2023-06-23 11:02:42', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (150, 84, 'Delete', 'Y', 'Y', 4, '2023-06-23 11:02:52', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (151, 191, 'Add', 'Y', 'Y', 4, '2023-06-23 19:47:38', '2023-06-23 21:36:33', 4);
INSERT INTO `user_action_permission_action` VALUES (152, 191, 'View', 'Y', 'Y', 4, '2023-06-23 19:47:43', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (153, 191, 'Edit', 'Y', 'Y', 4, '2023-06-23 21:36:36', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (154, 191, 'Delete', 'Y', 'Y', 4, '2023-06-23 21:36:41', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (155, 189, 'View', 'Y', 'Y', 4, '2023-06-23 21:55:54', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (156, 189, 'Edit', 'N', 'Y', 4, '2023-06-23 21:56:00', '2023-06-23 21:56:41', 4);
INSERT INTO `user_action_permission_action` VALUES (157, 189, 'Delete', 'N', 'Y', 4, '2023-06-23 21:56:05', '2023-06-23 21:57:47', 4);
INSERT INTO `user_action_permission_action` VALUES (158, 195, 'Add', 'Y', 'Y', 4, '2023-07-06 15:34:15', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (159, 195, 'View', 'Y', 'Y', 4, '2023-07-06 15:34:19', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (160, 195, 'Edit', 'Y', 'Y', 4, '2023-07-06 15:34:24', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (161, 195, 'Delete', 'Y', 'Y', 4, '2023-07-06 15:34:28', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (162, 194, 'Add', 'Y', 'Y', 4, '2023-07-06 15:34:32', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (163, 194, 'View', 'Y', 'Y', 4, '2023-07-06 15:34:37', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (164, 194, 'Edit', 'Y', 'Y', 4, '2023-07-10 11:15:55', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (165, 194, 'Delete', 'Y', 'Y', 4, '2023-07-11 11:38:30', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (166, 196, 'Add', 'Y', 'Y', 4, '2023-07-27 17:13:00', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (167, 196, 'View', 'Y', 'Y', 4, '2023-07-27 17:13:06', NULL, NULL);
INSERT INTO `user_action_permission_action` VALUES (168, 196, 'Edit', 'Y', 'Y', 4, '2023-07-27 17:13:10', NULL, NULL);

-- ----------------------------
-- Table structure for user_branch_change_history
-- ----------------------------
DROP TABLE IF EXISTS `user_branch_change_history`;
CREATE TABLE `user_branch_change_history`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `user_current_branch_id` int NOT NULL,
  `user_updated_branch_id` int NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Y=Yes, N=No',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_branch_change_history
-- ----------------------------
INSERT INTO `user_branch_change_history` VALUES (1, 6, 2, 4, 'Y', '2023-06-20 14:02:19', 4, NULL, 0);
INSERT INTO `user_branch_change_history` VALUES (2, 4, 3, 6, 'Y', '2023-06-21 21:33:56', 4, NULL, 0);
INSERT INTO `user_branch_change_history` VALUES (3, 11, 3, 5, 'Y', '2023-06-24 10:27:31', 4, NULL, 0);
INSERT INTO `user_branch_change_history` VALUES (4, 12, 3, 5, 'Y', '2023-06-24 10:29:27', 4, NULL, 0);

-- ----------------------------
-- Table structure for user_login_histories
-- ----------------------------
DROP TABLE IF EXISTS `user_login_histories`;
CREATE TABLE `user_login_histories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `login_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `login_postal_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ip_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_login_time` datetime NOT NULL,
  `user_logout_time` datetime NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 390 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_login_histories
-- ----------------------------
INSERT INTO `user_login_histories` VALUES (4, 4, 'Durgapur', '742187', '42.105.6.175', '2023-03-30 15:23:35', '2023-03-30 15:24:07', 'Y', '2023-03-30 09:54:07', 4, '2023-03-30 15:24:07', NULL);
INSERT INTO `user_login_histories` VALUES (5, 4, 'Durgapur', '742187', '42.105.4.15', '2023-03-30 22:42:04', NULL, 'Y', '2023-03-30 22:42:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (6, 4, 'Siliguri', '734011', '152.58.138.7', '2023-03-31 13:51:21', NULL, 'Y', '2023-03-31 13:51:21', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (7, 4, 'Kolkata', '700006', '42.110.204.109', '2023-03-31 16:33:16', NULL, 'Y', '2023-03-31 16:33:16', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (8, 4, 'Kolkata', '700078', '49.37.39.88', '2023-04-03 21:12:25', NULL, 'Y', '2023-04-03 21:12:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (9, 4, 'Kharagpur', '721301', '106.196.13.34', '2023-04-05 09:49:49', NULL, 'Y', '2023-04-05 09:49:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (10, 4, 'Kolkata', '700071', '49.37.37.108', '2023-04-05 10:11:28', NULL, 'Y', '2023-04-05 10:11:28', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (11, 4, 'Kolkata', '700047', '157.40.187.213', '2023-04-05 21:21:44', NULL, 'Y', '2023-04-05 21:21:44', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (12, 4, 'Kolkata', '700006', '110.224.107.71', '2023-04-06 15:16:03', '2023-04-06 15:18:52', 'Y', '2023-04-06 09:48:52', 4, '2023-04-06 15:18:52', NULL);
INSERT INTO `user_login_histories` VALUES (13, 4, 'Kolkata', '700006', '223.223.154.162', '2023-04-06 17:19:55', NULL, 'Y', '2023-04-06 17:19:55', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (14, 4, 'Kolkata', '700006', '110.224.107.242', '2023-04-06 20:11:38', '2023-04-06 20:13:32', 'Y', '2023-04-06 14:43:32', 4, '2023-04-06 20:13:32', NULL);
INSERT INTO `user_login_histories` VALUES (15, 4, 'Kolkata', '700006', '110.224.107.242', '2023-04-06 20:14:20', '2023-04-06 20:14:28', 'Y', '2023-04-06 14:44:28', 4, '2023-04-06 20:14:28', NULL);
INSERT INTO `user_login_histories` VALUES (16, 4, 'Kolkata', '700099', '223.223.154.162', '2023-04-07 14:11:58', '2023-04-07 15:35:04', 'Y', '2023-04-07 10:05:04', 4, '2023-04-07 15:35:04', NULL);
INSERT INTO `user_login_histories` VALUES (17, 4, 'Gangārāmpur', '733124', '103.77.136.156', '2023-04-07 15:37:27', NULL, 'Y', '2023-04-07 15:37:27', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (18, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-10 11:36:22', NULL, 'Y', '2023-04-10 11:36:22', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (19, 4, 'Kolkata', '700006', '171.51.129.116', '2023-04-10 11:59:46', NULL, 'Y', '2023-04-10 11:59:46', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (20, 4, 'Guskhara', '713403', '171.51.137.39', '2023-04-10 16:39:02', NULL, 'Y', '2023-04-10 16:39:02', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (21, 4, 'Raghunathpur', '723155', '106.194.92.218', '2023-04-11 14:19:40', NULL, 'Y', '2023-04-11 14:19:40', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (22, 4, 'Kolkata', '700019', '49.37.39.58', '2023-04-12 11:04:05', NULL, 'Y', '2023-04-12 11:04:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (23, 4, 'Kharagpur', '721301', '106.196.14.238', '2023-04-12 12:33:32', NULL, 'Y', '2023-04-12 12:33:32', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (24, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-12 17:47:38', NULL, 'Y', '2023-04-12 17:47:38', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (25, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-13 09:34:46', NULL, 'Y', '2023-04-13 09:34:46', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (26, 4, 'Kolkata', '700040', '49.37.39.88', '2023-04-13 11:45:49', NULL, 'Y', '2023-04-13 11:45:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (27, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-13 16:06:55', NULL, 'Y', '2023-04-13 16:06:55', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (28, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-13 17:00:54', NULL, 'Y', '2023-04-13 17:00:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (29, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-14 10:59:41', NULL, 'Y', '2023-04-14 10:59:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (30, 4, 'Kolkata', '700036', '49.37.39.234', '2023-04-14 13:14:12', NULL, 'Y', '2023-04-14 13:14:12', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (31, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-16 12:59:24', NULL, 'Y', '2023-04-16 12:59:24', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (32, 4, 'Hyderābād', '500001', '152.58.196.124', '2023-04-17 09:58:41', NULL, 'Y', '2023-04-17 09:58:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (33, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-17 16:15:49', NULL, 'Y', '2023-04-17 16:15:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (34, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-18 10:16:06', '2023-04-18 11:30:04', 'Y', '2023-04-18 06:00:04', 4, '2023-04-18 11:30:04', NULL);
INSERT INTO `user_login_histories` VALUES (35, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-18 13:43:04', NULL, 'Y', '2023-04-18 13:43:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (36, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-18 16:40:12', NULL, 'Y', '2023-04-18 16:40:12', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (37, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-19 14:55:21', NULL, 'Y', '2023-04-19 14:55:21', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (38, 4, 'Koch Bihār', '736158', '103.77.136.172', '2023-04-19 15:41:46', NULL, 'Y', '2023-04-19 15:41:46', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (39, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-19 18:52:09', NULL, 'Y', '2023-04-19 18:52:09', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (40, 4, 'Kolkata', '700006', '110.224.98.195', '2023-04-20 10:12:55', NULL, 'Y', '2023-04-20 10:12:55', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (41, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-20 11:06:50', '2023-04-20 11:08:41', 'Y', '2023-04-20 05:38:41', 4, '2023-04-20 11:08:41', NULL);
INSERT INTO `user_login_histories` VALUES (42, 4, 'Kolkata', '700053', '49.37.37.176', '2023-04-20 11:26:07', NULL, 'Y', '2023-04-20 11:26:07', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (43, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-04-20 14:56:32', NULL, 'Y', '2023-04-20 14:56:32', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (44, 4, 'Kolkata', '700037', '49.37.41.158', '2023-04-20 16:18:42', NULL, 'Y', '2023-04-20 16:18:42', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (45, 4, 'Kolkata', '700006', '45.250.51.236', '2023-04-20 20:22:13', NULL, 'Y', '2023-04-20 20:22:13', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (46, 4, 'Kāvali', '524411', '175.101.68.55', '2023-04-21 09:23:17', NULL, 'Y', '2023-04-21 09:23:17', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (47, 4, 'Kāvali', '524411', '175.101.68.55', '2023-04-21 11:54:28', NULL, 'Y', '2023-04-21 11:54:28', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (48, 4, 'Kolkata', '700006', '45.250.51.236', '2023-04-21 14:49:25', NULL, 'Y', '2023-04-21 14:49:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (49, 4, 'Siliguri', '734011', '152.58.140.51', '2023-04-24 10:41:18', NULL, 'Y', '2023-04-24 10:41:18', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (50, 4, 'Kharagpur', '721301', '106.196.0.214', '2023-04-24 14:08:48', NULL, 'Y', '2023-04-24 14:08:48', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (51, 4, 'Siliguri', '734011', '152.58.165.104', '2023-04-24 16:08:41', NULL, 'Y', '2023-04-24 16:08:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (52, 4, 'Mākhjan', '416704', '223.237.108.213', '2023-04-24 18:56:41', NULL, 'Y', '2023-04-24 18:56:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (53, 4, 'Kāvali', '524411', '175.101.68.55', '2023-04-26 12:34:27', '2023-04-26 12:34:57', 'Y', '2023-04-26 07:04:57', 4, '2023-04-26 12:34:57', NULL);
INSERT INTO `user_login_histories` VALUES (54, 4, 'Durgapur', '742187', '103.102.122.45', '2023-04-28 16:48:47', NULL, 'Y', '2023-04-28 16:48:47', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (55, 4, 'Visakhapatnam', '530044', '49.204.237.117', '2023-05-01 17:35:37', NULL, 'Y', '2023-05-01 17:35:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (56, 4, 'Kharagpur', '721301', '106.196.1.57', '2023-05-02 10:09:06', NULL, 'Y', '2023-05-02 10:09:06', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (57, 4, 'Kharagpur', '721301', '106.196.1.57', '2023-05-02 16:59:09', NULL, 'Y', '2023-05-02 16:59:09', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (58, 4, 'Hyderābād', '500001', '152.58.234.229', '2023-05-03 08:59:57', '2023-05-03 09:03:07', 'Y', '2023-05-03 03:33:07', 4, '2023-05-03 09:03:07', NULL);
INSERT INTO `user_login_histories` VALUES (59, 4, 'Visakhapatnam', '530044', '106.76.202.165', '2023-05-03 09:58:51', NULL, 'Y', '2023-05-03 09:58:51', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (60, 4, 'Kolkata', '700019', '49.37.8.166', '2023-05-03 11:09:55', NULL, 'Y', '2023-05-03 11:09:55', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (61, 4, 'Visakhapatnam', '530044', '125.62.195.19', '2023-05-03 13:03:57', '2023-05-03 13:10:25', 'Y', '2023-05-03 07:40:25', 4, '2023-05-03 13:10:25', NULL);
INSERT INTO `user_login_histories` VALUES (62, 4, 'Visakhapatnam', '530044', '125.62.195.19', '2023-05-03 13:44:51', '2023-05-03 13:46:47', 'Y', '2023-05-03 08:16:47', 4, '2023-05-03 13:46:47', NULL);
INSERT INTO `user_login_histories` VALUES (63, 4, 'Visakhapatnam', '530044', '125.62.195.19', '2023-05-03 13:47:16', '2023-05-03 13:58:33', 'Y', '2023-05-03 08:28:33', 4, '2023-05-03 13:58:33', NULL);
INSERT INTO `user_login_histories` VALUES (64, 4, 'Visakhapatnam', '530044', '125.62.195.19', '2023-05-03 14:09:49', '2023-05-03 14:09:56', 'Y', '2023-05-03 08:39:56', 4, '2023-05-03 14:09:56', NULL);
INSERT INTO `user_login_histories` VALUES (65, 4, 'Dīnhāta', '736135', '116.193.142.195', '2023-05-03 14:22:37', '2023-05-03 14:24:55', 'Y', '2023-05-03 08:54:55', 4, '2023-05-03 14:24:55', NULL);
INSERT INTO `user_login_histories` VALUES (66, 4, 'Visakhapatnam', '530044', '125.62.195.19', '2023-05-03 14:24:57', NULL, 'Y', '2023-05-03 14:24:57', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (67, 4, 'Dīnhāta', '736135', '116.193.142.195', '2023-05-03 14:27:31', NULL, 'Y', '2023-05-03 14:27:31', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (68, 4, 'Hyderābād', '500001', '152.58.196.180', '2023-05-03 17:55:52', '2023-05-03 18:29:05', 'Y', '2023-05-03 12:59:05', 4, '2023-05-03 18:29:05', NULL);
INSERT INTO `user_login_histories` VALUES (69, 4, 'Hyderābād', '500001', '152.58.196.226', '2023-05-03 18:29:22', NULL, 'Y', '2023-05-03 18:29:22', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (70, 4, 'Kolkata', '700037', '49.37.11.62', '2023-05-04 11:34:19', NULL, 'Y', '2023-05-04 11:34:19', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (71, 4, 'Sattenapalle', '522437', '175.101.68.55', '2023-05-05 10:40:40', NULL, 'Y', '2023-05-05 10:40:40', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (72, 4, 'Kolkata', '700040', '49.37.11.62', '2023-05-05 11:55:36', NULL, 'Y', '2023-05-05 11:55:36', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (73, 4, 'Sattenapalle', '522437', '175.101.68.55', '2023-05-07 11:45:23', NULL, 'Y', '2023-05-07 11:45:23', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (74, 4, 'Bengaluru', '560002', '49.205.142.182', '2023-05-07 12:24:36', NULL, 'Y', '2023-05-07 12:24:36', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (75, 4, 'Sattenapalle', '522437', '175.101.68.55', '2023-05-08 13:03:18', NULL, 'Y', '2023-05-08 13:03:18', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (76, 4, 'Kolkata', '700046', '223.233.49.100', '2023-05-09 15:36:44', NULL, 'Y', '2023-05-09 15:36:44', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (77, 4, 'Kolkata', '700015', '110.224.102.203', '2023-05-11 19:43:17', NULL, 'Y', '2023-05-11 19:43:17', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (78, 4, 'Kolkata', '700036', '49.37.9.232', '2023-05-12 11:09:49', NULL, 'Y', '2023-05-12 11:09:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (79, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-12 12:39:59', NULL, 'Y', '2023-05-12 12:39:59', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (80, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-12 16:20:33', NULL, 'Y', '2023-05-12 16:20:33', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (81, 4, 'Kolkata', '700036', '49.37.9.232', '2023-05-12 18:07:05', NULL, 'Y', '2023-05-12 18:07:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (82, 4, 'Kharagpur', '721301', '106.196.10.89', '2023-05-15 10:11:13', NULL, 'Y', '2023-05-15 10:11:13', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (83, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-15 10:33:09', NULL, 'Y', '2023-05-15 10:33:09', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (84, 4, 'Kolkata', '700047', '49.37.8.201', '2023-05-15 10:52:08', NULL, 'Y', '2023-05-15 10:52:08', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (85, 4, 'Kharagpur', '721301', '106.196.10.89', '2023-05-15 12:52:40', NULL, 'Y', '2023-05-15 12:52:40', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (86, 4, 'Durgapur', '742187', '42.105.1.220', '2023-05-18 10:19:56', NULL, 'Y', '2023-05-18 10:19:56', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (87, 4, 'Gangtok', '737135', '117.226.170.34', '2023-05-18 10:51:36', NULL, 'Y', '2023-05-18 10:51:36', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (88, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-19 10:29:22', NULL, 'Y', '2023-05-19 10:29:22', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (89, 4, 'Kolkata', '700037', '157.40.79.220', '2023-05-19 15:57:11', NULL, 'Y', '2023-05-19 15:57:11', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (90, 4, 'Rāiganj', '735101', '117.226.154.68', '2023-05-19 20:28:22', NULL, 'Y', '2023-05-19 20:28:22', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (91, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-19 22:15:25', NULL, 'Y', '2023-05-19 22:15:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (92, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-20 09:29:37', NULL, 'Y', '2023-05-20 09:29:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (93, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-20 14:25:04', NULL, 'Y', '2023-05-20 14:25:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (94, 4, 'Hyderābād', '500001', '152.58.197.76', '2023-05-22 08:14:35', NULL, 'Y', '2023-05-22 08:14:35', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (95, 4, 'Siliguri', '734011', '223.187.245.55', '2023-05-22 18:10:23', NULL, 'Y', '2023-05-22 18:10:23', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (96, 4, 'Kolkata', '700063', '49.37.34.146', '2023-05-22 18:46:46', NULL, 'Y', '2023-05-22 18:46:46', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (97, 4, 'Bengaluru', '560002', '49.205.138.252', '2023-05-22 19:56:26', '2023-05-22 21:38:26', 'Y', '2023-05-22 16:08:26', 4, '2023-05-22 21:38:26', NULL);
INSERT INTO `user_login_histories` VALUES (98, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-22 20:43:12', NULL, 'Y', '2023-05-22 20:43:12', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (99, 4, 'Hyderābād', '500001', '152.58.196.156', '2023-05-23 12:33:41', NULL, 'Y', '2023-05-23 12:33:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (100, 4, 'Kolkata', '700063', '49.37.34.90', '2023-05-23 12:34:50', NULL, 'Y', '2023-05-23 12:34:50', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (101, 4, 'Baharampur', '742121', '223.237.85.52', '2023-05-23 13:02:36', NULL, 'Y', '2023-05-23 13:02:36', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (102, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-23 21:22:37', NULL, 'Y', '2023-05-23 21:22:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (103, 4, 'Kolkata', '700042', '117.227.68.62', '2023-05-24 10:20:01', NULL, 'Y', '2023-05-24 10:20:01', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (104, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-24 12:18:25', NULL, 'Y', '2023-05-24 12:18:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (105, 4, 'Vijayawada', '520004', '175.101.68.55', '2023-05-25 22:14:07', NULL, 'Y', '2023-05-25 22:14:07', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (106, 4, 'Bhattiprolu', '522201', '175.101.68.55', '2023-05-27 09:01:25', NULL, 'Y', '2023-05-27 09:01:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (107, 4, 'Bhattiprolu', '522201', '175.101.68.55', '2023-05-27 17:17:36', NULL, 'Y', '2023-05-27 17:17:36', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (108, 4, 'Bhattiprolu', '522201', '175.101.68.55', '2023-05-29 17:44:10', '2023-05-29 17:44:41', 'Y', '2023-05-29 12:14:41', 4, '2023-05-29 17:44:41', NULL);
INSERT INTO `user_login_histories` VALUES (109, 4, 'Naksalbāri', '734421', '223.237.69.61', '2023-05-30 10:17:58', NULL, 'Y', '2023-05-30 10:17:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (110, 4, 'Hāora', '711106', '49.37.34.62', '2023-05-30 10:32:51', NULL, 'Y', '2023-05-30 10:32:51', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (111, 4, 'Bhattiprolu', '522202', '175.101.68.55', '2023-05-31 11:14:21', NULL, 'Y', '2023-05-31 11:14:21', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (112, 4, 'Siliguri', '734011', '47.11.193.69', '2023-05-31 18:10:01', NULL, 'Y', '2023-05-31 18:10:01', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (113, 4, 'Kolkata', '700041', '38.156.47.38', '2023-06-01 10:36:02', NULL, 'Y', '2023-06-01 10:36:02', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (114, 4, 'Kolkata', '700019', '117.226.255.141', '2023-06-01 16:01:41', NULL, 'Y', '2023-06-01 16:01:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (115, 4, 'Kolkata', '700041', '38.156.47.38', '2023-06-01 16:31:51', NULL, 'Y', '2023-06-01 16:31:51', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (116, 4, 'Kolkata', '700037', '117.226.201.199', '2023-06-01 22:33:02', NULL, 'Y', '2023-06-01 22:33:02', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (117, 4, 'Port Blair', '744106', '117.226.222.61', '2023-06-02 08:27:52', NULL, 'Y', '2023-06-02 08:27:52', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (118, 4, 'Port Blair', '744106', '117.226.222.61', '2023-06-02 09:19:28', '2023-06-02 10:59:28', 'Y', '2023-06-02 05:29:28', 4, '2023-06-02 10:59:28', NULL);
INSERT INTO `user_login_histories` VALUES (119, 4, 'Port Blair', '744106', '117.226.222.61', '2023-06-02 10:59:58', NULL, 'Y', '2023-06-02 10:59:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (120, 4, 'Kolkata', '700047', '49.37.34.134', '2023-06-02 11:32:21', NULL, 'Y', '2023-06-02 11:32:21', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (121, 4, 'Bengaluru', '560002', '49.205.140.225', '2023-06-02 14:04:43', '2023-06-02 14:39:29', 'Y', '2023-06-02 09:09:29', 4, '2023-06-02 14:39:29', NULL);
INSERT INTO `user_login_histories` VALUES (122, 4, 'Siliguri', '734011', '47.11.84.110', '2023-06-03 08:57:33', NULL, 'Y', '2023-06-03 08:57:33', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (123, 4, 'Bengaluru', '560002', '152.58.209.123', '2023-06-03 10:30:45', NULL, 'Y', '2023-06-03 10:30:45', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (124, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-03 12:18:03', NULL, 'Y', '2023-06-03 12:18:03', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (125, 4, 'Kolkata', '700043', '38.156.47.38', '2023-06-03 22:37:27', NULL, 'Y', '2023-06-03 22:37:27', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (126, 4, 'Kolkata', '700043', '38.156.47.38', '2023-06-04 16:12:54', NULL, 'Y', '2023-06-04 16:12:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (127, 4, 'Kolkata', '700006', '103.171.246.154', '2023-06-05 09:52:58', NULL, 'Y', '2023-06-05 09:52:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (128, 4, 'Kolkata', '700043', '38.156.47.38', '2023-06-05 10:57:27', NULL, 'Y', '2023-06-05 10:57:27', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (129, 4, 'Kolkata', '700047', '49.37.32.124', '2023-06-05 15:09:03', NULL, 'Y', '2023-06-05 15:09:03', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (130, 4, 'Kolkata', '700047', '49.37.32.124', '2023-06-05 19:35:20', NULL, 'Y', '2023-06-05 19:35:20', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (131, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 12:12:54', NULL, 'Y', '2023-06-06 12:12:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (132, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 13:41:14', NULL, 'Y', '2023-06-06 13:41:14', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (133, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 14:28:25', NULL, 'Y', '2023-06-06 14:28:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (134, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 14:28:45', NULL, 'Y', '2023-06-06 14:28:45', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (135, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 14:30:17', NULL, 'Y', '2023-06-06 14:30:17', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (136, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 14:31:04', NULL, 'Y', '2023-06-06 14:31:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (137, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 15:34:31', NULL, 'Y', '2023-06-06 15:34:31', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (138, 4, 'Kolkata', '700002', '103.175.168.84', '2023-06-06 15:36:04', NULL, 'Y', '2023-06-06 15:36:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (139, 4, 'Kolkata', '700046', '49.37.32.96', '2023-06-07 11:16:54', NULL, 'Y', '2023-06-07 11:16:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (140, 4, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 11:22:30', NULL, 'Y', '2023-06-07 11:22:30', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (141, 6, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 15:36:11', NULL, 'Y', '2023-06-07 15:36:11', 6, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (142, 4, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 18:18:30', NULL, 'Y', '2023-06-07 18:18:30', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (143, 4, 'Kolkata', '700046', '38.156.47.38', '2023-06-07 18:28:56', NULL, 'Y', '2023-06-07 18:28:56', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (144, 4, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 19:37:16', '2023-06-07 19:52:13', 'Y', '2023-06-07 14:22:13', 4, '2023-06-07 19:52:13', NULL);
INSERT INTO `user_login_histories` VALUES (145, 7, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 19:43:14', NULL, 'Y', '2023-06-07 19:43:14', 7, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (146, 9, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 19:52:35', '2023-06-07 20:38:40', 'Y', '2023-06-07 15:08:40', 9, '2023-06-07 20:38:40', NULL);
INSERT INTO `user_login_histories` VALUES (147, 8, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 19:53:21', NULL, 'Y', '2023-06-07 19:53:21', 8, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (148, 4, 'Bengaluru', '560002', '49.205.143.92', '2023-06-07 20:04:52', NULL, 'Y', '2023-06-07 20:04:52', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (149, 4, 'Kolkata', '700006', '160.238.92.155', '2023-06-07 20:38:54', NULL, 'Y', '2023-06-07 20:38:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (150, 4, 'Kolkata', '700006', '146.196.45.252', '2023-06-08 08:34:16', NULL, 'Y', '2023-06-08 08:34:16', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (151, 7, 'Kolkata', '700006', '146.196.45.252', '2023-06-08 08:35:09', NULL, 'Y', '2023-06-08 08:35:09', 7, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (152, 8, 'Kolkata', '700006', '146.196.45.252', '2023-06-08 08:35:56', NULL, 'Y', '2023-06-08 08:35:56', 8, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (153, 9, 'Kolkata', '700006', '146.196.45.252', '2023-06-08 08:36:29', NULL, 'Y', '2023-06-08 08:36:29', 9, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (154, 9, 'Kolkata', '700006', '146.196.45.252', '2023-06-08 10:34:34', NULL, 'Y', '2023-06-08 10:34:34', 9, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (155, 7, 'Kolkata', '700006', '146.196.45.252', '2023-06-08 10:35:07', NULL, 'Y', '2023-06-08 10:35:07', 7, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (156, 4, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 11:18:18', '2023-06-08 12:41:53', 'Y', '2023-06-08 07:11:53', 4, '2023-06-08 12:41:53', NULL);
INSERT INTO `user_login_histories` VALUES (157, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-08 11:41:10', NULL, 'Y', '2023-06-08 11:41:10', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (158, 4, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 12:42:05', NULL, 'Y', '2023-06-08 12:42:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (159, 9, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 12:43:09', '2023-06-08 12:43:37', 'Y', '2023-06-08 07:13:37', 9, '2023-06-08 12:43:37', NULL);
INSERT INTO `user_login_histories` VALUES (160, 7, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 12:43:51', '2023-06-08 12:45:35', 'Y', '2023-06-08 07:15:35', 7, '2023-06-08 12:45:35', NULL);
INSERT INTO `user_login_histories` VALUES (161, 9, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 12:45:59', '2023-06-08 12:46:10', 'Y', '2023-06-08 07:16:10', 9, '2023-06-08 12:46:10', NULL);
INSERT INTO `user_login_histories` VALUES (162, 8, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 12:46:34', '2023-06-08 12:47:08', 'Y', '2023-06-08 07:17:08', 8, '2023-06-08 12:47:08', NULL);
INSERT INTO `user_login_histories` VALUES (163, 9, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 12:47:26', '2023-06-08 14:49:27', 'Y', '2023-06-08 09:19:27', 9, '2023-06-08 14:49:27', NULL);
INSERT INTO `user_login_histories` VALUES (164, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-08 13:56:44', NULL, 'Y', '2023-06-08 13:56:44', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (165, 7, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 14:50:05', '2023-06-08 14:53:29', 'Y', '2023-06-08 09:23:29', 7, '2023-06-08 14:53:29', NULL);
INSERT INTO `user_login_histories` VALUES (166, 8, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 14:54:03', '2023-06-08 14:55:10', 'Y', '2023-06-08 09:25:10', 8, '2023-06-08 14:55:10', NULL);
INSERT INTO `user_login_histories` VALUES (167, 9, 'Kolkata', '700044', '49.37.32.96', '2023-06-08 14:55:33', NULL, 'Y', '2023-06-08 14:55:33', 9, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (168, 7, 'Kolkata', '700044', '38.156.47.38', '2023-06-08 16:03:14', NULL, 'Y', '2023-06-08 16:03:14', 7, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (169, 4, 'Bengaluru', '560002', '49.205.143.92', '2023-06-08 16:57:30', NULL, 'Y', '2023-06-08 16:57:30', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (170, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-08 18:55:42', NULL, 'Y', '2023-06-08 18:55:42', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (171, 4, 'Kolkata', '700015', '49.37.32.96', '2023-06-08 22:18:34', NULL, 'Y', '2023-06-08 22:18:34', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (172, 4, 'Kolkata', '700015', '49.37.32.96', '2023-06-08 22:22:49', NULL, 'Y', '2023-06-08 22:22:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (173, 4, 'Bengaluru', '560002', '49.205.143.92', '2023-06-08 22:41:07', NULL, 'Y', '2023-06-08 22:41:07', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (174, 4, 'Bengaluru', '560002', '49.205.143.92', '2023-06-09 10:04:45', NULL, 'Y', '2023-06-09 10:04:45', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (175, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-09 10:13:50', NULL, 'Y', '2023-06-09 10:13:50', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (176, 4, 'Dam Dam', '700134', '49.37.35.108', '2023-06-09 10:23:47', NULL, 'Y', '2023-06-09 10:23:47', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (177, 4, 'Kolkata', '700006', '146.196.47.76', '2023-06-09 12:04:40', NULL, 'Y', '2023-06-09 12:04:40', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (178, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-09 15:02:31', NULL, 'Y', '2023-06-09 15:02:31', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (179, 4, 'Kolkata', '700046', '38.156.47.38', '2023-06-09 22:31:43', NULL, 'Y', '2023-06-09 22:31:43', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (180, 4, 'Bengaluru', '560002', '49.205.143.92', '2023-06-10 09:25:37', '2023-06-10 09:26:26', 'Y', '2023-06-10 03:56:26', 4, '2023-06-10 09:26:26', NULL);
INSERT INTO `user_login_histories` VALUES (181, 4, 'Hoskote', '560022', '49.205.136.68', '2023-06-11 17:59:14', NULL, 'Y', '2023-06-11 17:59:14', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (182, 4, 'Durgapur', '742187', '42.105.0.100', '2023-06-11 20:44:07', NULL, 'Y', '2023-06-11 20:44:07', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (183, 4, 'Hoskote', '560022', '49.205.136.68', '2023-06-12 10:08:04', NULL, 'Y', '2023-06-12 10:08:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (184, 4, 'Kolkata', '700006', '103.151.156.71', '2023-06-12 10:19:30', NULL, 'Y', '2023-06-12 10:19:30', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (185, 4, 'Kolkata', '700042', '38.156.47.38', '2023-06-12 10:21:28', NULL, 'Y', '2023-06-12 10:21:28', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (186, 4, 'Durgapur', '742187', '42.105.0.160', '2023-06-12 10:22:21', NULL, 'Y', '2023-06-12 10:22:21', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (187, 4, 'Hoskote', '560022', '49.205.136.68', '2023-06-12 15:46:39', '2023-06-12 15:47:42', 'Y', '2023-06-12 10:17:42', 4, '2023-06-12 15:47:42', NULL);
INSERT INTO `user_login_histories` VALUES (188, 4, 'Kolkata', '700006', '103.151.156.71', '2023-06-12 19:05:29', NULL, 'Y', '2023-06-12 19:05:29', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (189, 4, 'Kolkata', '700042', '38.156.47.38', '2023-06-12 19:34:11', NULL, 'Y', '2023-06-12 19:34:11', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (190, 4, 'Durgapur', '742187', '42.105.7.219', '2023-06-12 23:17:29', NULL, 'Y', '2023-06-12 23:17:29', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (191, 4, 'Kolkata', '700053', '103.175.62.152', '2023-06-13 10:11:39', NULL, 'Y', '2023-06-13 10:11:39', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (192, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-13 10:30:00', NULL, 'Y', '2023-06-13 10:30:00', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (193, 4, 'Durgapur', '742187', '42.105.113.142', '2023-06-13 10:39:30', NULL, 'Y', '2023-06-13 10:39:30', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (194, 4, 'Kolkata', '700044', '38.156.47.38', '2023-06-13 13:13:42', NULL, 'Y', '2023-06-13 13:13:42', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (195, 4, 'Hoskote', '560024', '49.205.136.68', '2023-06-13 13:47:37', NULL, 'Y', '2023-06-13 13:47:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (196, 4, 'Durgapur', '742187', '45.116.191.211', '2023-06-13 18:57:52', NULL, 'Y', '2023-06-13 18:57:52', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (197, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-14 09:37:50', NULL, 'Y', '2023-06-14 09:37:50', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (198, 4, 'Durgapur', '742187', '42.105.0.193', '2023-06-14 10:02:47', NULL, 'Y', '2023-06-14 10:02:47', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (199, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-14 16:44:08', NULL, 'Y', '2023-06-14 16:44:08', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (200, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-14 19:08:56', NULL, 'Y', '2023-06-14 19:08:56', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (201, 4, 'Kolkata', '700006', '103.211.135.79', '2023-06-14 19:25:04', NULL, 'Y', '2023-06-14 19:25:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (202, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-15 09:21:13', NULL, 'Y', '2023-06-15 09:21:13', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (203, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-15 11:45:04', NULL, 'Y', '2023-06-15 11:45:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (204, 4, 'Durgapur', '742187', '42.105.6.4', '2023-06-15 15:02:08', NULL, 'Y', '2023-06-15 15:02:08', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (205, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-15 16:44:48', NULL, 'Y', '2023-06-15 16:44:48', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (206, 4, 'Kolkata', '700046', '38.156.47.38', '2023-06-15 23:00:18', NULL, 'Y', '2023-06-15 23:00:18', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (207, 4, 'Bengaluru', '560002', '49.205.137.4', '2023-06-16 10:06:32', '2023-06-16 10:08:21', 'Y', '2023-06-16 04:38:21', 4, '2023-06-16 10:08:21', NULL);
INSERT INTO `user_login_histories` VALUES (208, 4, 'Kolkata', '700046', '38.156.47.38', '2023-06-16 10:14:29', NULL, 'Y', '2023-06-16 10:14:29', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (209, 4, 'Bengaluru', '560002', '49.205.137.4', '2023-06-16 10:38:42', NULL, 'Y', '2023-06-16 10:38:42', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (210, 4, 'Durgapur', '742187', '42.105.0.16', '2023-06-16 10:49:22', NULL, 'Y', '2023-06-16 10:49:22', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (211, 4, 'Kolkata', '700006', '103.171.246.151', '2023-06-16 11:55:40', NULL, 'Y', '2023-06-16 11:55:40', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (212, 4, 'Kolkata', '700046', '38.156.47.38', '2023-06-16 14:10:05', NULL, 'Y', '2023-06-16 14:10:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (213, 4, 'Kolkata', '700006', '103.211.20.171', '2023-06-16 21:04:15', '2023-06-16 22:25:27', 'Y', '2023-06-16 16:55:27', 4, '2023-06-16 22:25:27', NULL);
INSERT INTO `user_login_histories` VALUES (214, 4, 'Doddaballapura', '560078', '49.205.136.187', '2023-06-16 22:48:28', '2023-06-16 22:49:54', 'Y', '2023-06-16 17:19:54', 4, '2023-06-16 22:49:54', NULL);
INSERT INTO `user_login_histories` VALUES (215, 4, 'Bengaluru', '560002', '49.205.137.4', '2023-06-16 23:14:28', '2023-06-16 23:23:19', 'Y', '2023-06-16 17:53:19', 4, '2023-06-16 23:23:19', NULL);
INSERT INTO `user_login_histories` VALUES (216, 4, 'Bengaluru', '560002', '49.205.137.4', '2023-06-17 09:29:29', NULL, 'Y', '2023-06-17 09:29:29', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (217, 4, 'Hoskote', '560022', '49.205.137.4', '2023-06-18 21:58:29', '2023-06-18 22:05:15', 'Y', '2023-06-18 16:35:15', 4, '2023-06-18 22:05:15', NULL);
INSERT INTO `user_login_histories` VALUES (218, 4, 'Hoskote', '560026', '49.205.137.4', '2023-06-18 22:05:41', NULL, 'Y', '2023-06-18 22:05:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (219, 4, 'Hoskote', '560026', '49.205.137.4', '2023-06-19 09:03:27', NULL, 'Y', '2023-06-19 09:03:27', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (220, 4, 'Hoskote', '560022', '49.205.137.4', '2023-06-19 09:46:39', NULL, 'Y', '2023-06-19 09:46:39', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (221, 4, 'Durgapur', '742187', '42.105.100.221', '2023-06-19 11:18:54', NULL, 'Y', '2023-06-19 11:18:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (222, 4, 'Hoskote', '560022', '49.205.137.4', '2023-06-19 14:02:49', NULL, 'Y', '2023-06-19 14:02:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (223, 4, 'Hoskote', '560022', '49.205.137.4', '2023-06-19 22:11:39', NULL, 'Y', '2023-06-19 22:11:39', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (224, 4, 'Durgapur', '742187', '42.105.6.15', '2023-06-20 09:58:26', NULL, 'Y', '2023-06-20 09:58:26', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (225, 4, 'Siliguri', '734011', '47.11.28.183', '2023-06-20 10:04:58', NULL, 'Y', '2023-06-20 10:04:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (226, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-20 10:27:30', NULL, 'Y', '2023-06-20 10:27:30', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (227, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-20 10:44:27', NULL, 'Y', '2023-06-20 10:44:27', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (228, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-20 15:55:35', NULL, 'Y', '2023-06-20 15:55:35', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (229, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-20 17:35:23', NULL, 'Y', '2023-06-20 17:35:23', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (230, 4, 'Koch Bihār', '735122', '146.196.45.247', '2023-06-20 20:53:24', NULL, 'Y', '2023-06-20 20:53:24', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (231, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 09:17:57', '2023-06-21 10:10:43', 'Y', '2023-06-21 04:40:43', 4, '2023-06-21 10:10:43', NULL);
INSERT INTO `user_login_histories` VALUES (232, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 09:36:34', '2023-06-21 10:24:07', 'Y', '2023-06-21 04:54:07', 4, '2023-06-21 10:24:07', NULL);
INSERT INTO `user_login_histories` VALUES (233, 13, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:11:11', NULL, 'Y', '2023-06-21 10:11:11', 13, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (234, 13, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:27:14', '2023-06-21 10:29:00', 'Y', '2023-06-21 04:59:00', 13, '2023-06-21 10:29:00', NULL);
INSERT INTO `user_login_histories` VALUES (235, 11, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:31:48', NULL, 'Y', '2023-06-21 10:31:48', 11, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (236, 13, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:32:53', '2023-06-21 10:33:26', 'Y', '2023-06-21 05:03:26', 13, '2023-06-21 10:33:26', NULL);
INSERT INTO `user_login_histories` VALUES (237, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:33:49', '2023-06-21 10:38:07', 'Y', '2023-06-21 05:08:07', 4, '2023-06-21 10:38:07', NULL);
INSERT INTO `user_login_histories` VALUES (238, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:39:14', '2023-06-21 10:39:46', 'Y', '2023-06-21 05:09:46', 4, '2023-06-21 10:39:46', NULL);
INSERT INTO `user_login_histories` VALUES (239, 14, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:41:02', '2023-06-21 10:47:26', 'Y', '2023-06-21 05:17:26', 14, '2023-06-21 10:47:26', NULL);
INSERT INTO `user_login_histories` VALUES (240, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:43:57', NULL, 'Y', '2023-06-21 10:43:57', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (241, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 10:53:14', '2023-06-21 11:08:21', 'Y', '2023-06-21 05:38:21', 4, '2023-06-21 11:08:21', NULL);
INSERT INTO `user_login_histories` VALUES (242, 13, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:11:37', '2023-06-21 11:11:56', 'Y', '2023-06-21 05:41:56', 13, '2023-06-21 11:11:56', NULL);
INSERT INTO `user_login_histories` VALUES (243, 14, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:12:35', '2023-06-21 11:12:42', 'Y', '2023-06-21 05:42:42', 14, '2023-06-21 11:12:42', NULL);
INSERT INTO `user_login_histories` VALUES (244, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:17:00', NULL, 'Y', '2023-06-21 11:17:00', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (245, 16, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:18:09', '2023-06-21 11:18:25', 'Y', '2023-06-21 05:48:25', 16, '2023-06-21 11:18:25', NULL);
INSERT INTO `user_login_histories` VALUES (246, 15, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:19:25', '2023-06-21 11:19:43', 'Y', '2023-06-21 05:49:43', 15, '2023-06-21 11:19:43', NULL);
INSERT INTO `user_login_histories` VALUES (247, 17, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:20:27', '2023-06-21 11:20:50', 'Y', '2023-06-21 05:50:50', 17, '2023-06-21 11:20:50', NULL);
INSERT INTO `user_login_histories` VALUES (249, 19, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:22:25', '2023-06-21 11:22:35', 'Y', '2023-06-21 05:52:35', 19, '2023-06-21 11:22:35', NULL);
INSERT INTO `user_login_histories` VALUES (250, 12, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:23:19', '2023-06-21 11:23:33', 'Y', '2023-06-21 05:53:33', 12, '2023-06-21 11:23:33', NULL);
INSERT INTO `user_login_histories` VALUES (251, 11, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:24:09', '2023-06-21 11:24:18', 'Y', '2023-06-21 05:54:18', 11, '2023-06-21 11:24:18', NULL);
INSERT INTO `user_login_histories` VALUES (252, 11, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:24:57', '2023-06-21 13:48:40', 'Y', '2023-06-21 08:18:40', 11, '2023-06-21 13:48:40', NULL);
INSERT INTO `user_login_histories` VALUES (253, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 11:30:19', '2023-06-21 13:42:45', 'Y', '2023-06-21 08:12:45', 4, '2023-06-21 13:42:45', NULL);
INSERT INTO `user_login_histories` VALUES (254, 4, 'Dam Dam', '743247', '49.37.11.56', '2023-06-21 11:36:18', NULL, 'Y', '2023-06-21 11:36:18', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (255, 18, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 13:43:12', '2023-06-21 13:43:16', 'Y', '2023-06-21 08:13:16', 18, '2023-06-21 13:43:16', NULL);
INSERT INTO `user_login_histories` VALUES (256, 18, 'Dam Dam', '743247', '49.37.11.56', '2023-06-21 13:43:12', '2023-06-21 13:48:34', 'Y', '2023-06-21 08:18:34', 18, '2023-06-21 13:48:34', NULL);
INSERT INTO `user_login_histories` VALUES (257, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 13:49:11', NULL, 'Y', '2023-06-21 13:49:11', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (258, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 15:01:21', '2023-06-21 16:33:42', 'Y', '2023-06-21 11:03:42', 4, '2023-06-21 16:33:42', NULL);
INSERT INTO `user_login_histories` VALUES (259, 4, 'Bānkura', '722152', '117.227.104.171', '2023-06-21 16:17:05', NULL, 'Y', '2023-06-21 16:17:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (260, 19, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 16:34:11', '2023-06-21 16:34:32', 'Y', '2023-06-21 11:04:32', 19, '2023-06-21 16:34:32', NULL);
INSERT INTO `user_login_histories` VALUES (261, 18, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 16:35:01', '2023-06-21 16:35:23', 'Y', '2023-06-21 11:05:23', 18, '2023-06-21 16:35:23', NULL);
INSERT INTO `user_login_histories` VALUES (262, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 16:35:49', '2023-06-21 16:36:36', 'Y', '2023-06-21 11:06:36', 4, '2023-06-21 16:36:36', NULL);
INSERT INTO `user_login_histories` VALUES (263, 19, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 16:36:56', '2023-06-21 16:37:37', 'Y', '2023-06-21 11:07:37', 19, '2023-06-21 16:37:37', NULL);
INSERT INTO `user_login_histories` VALUES (264, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 16:37:58', '2023-06-21 16:39:12', 'Y', '2023-06-21 11:09:12', 4, '2023-06-21 16:39:12', NULL);
INSERT INTO `user_login_histories` VALUES (265, 18, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 16:39:27', '2023-06-21 17:37:12', 'Y', '2023-06-21 12:07:12', 18, '2023-06-21 17:37:12', NULL);
INSERT INTO `user_login_histories` VALUES (266, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 16:53:29', NULL, 'Y', '2023-06-21 16:53:29', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (267, 18, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 17:38:09', '2023-06-21 21:14:15', 'Y', '2023-06-21 15:44:15', 18, '2023-06-21 21:14:15', NULL);
INSERT INTO `user_login_histories` VALUES (268, 19, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 21:14:30', '2023-06-21 21:15:28', 'Y', '2023-06-21 15:45:28', 19, '2023-06-21 21:15:28', NULL);
INSERT INTO `user_login_histories` VALUES (269, 18, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 21:15:49', '2023-06-21 21:18:37', 'Y', '2023-06-21 15:48:37', 18, '2023-06-21 21:18:37', NULL);
INSERT INTO `user_login_histories` VALUES (270, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 21:18:54', '2023-06-21 21:19:41', 'Y', '2023-06-21 15:49:41', 4, '2023-06-21 21:19:41', NULL);
INSERT INTO `user_login_histories` VALUES (271, 19, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 21:19:56', '2023-06-21 21:21:19', 'Y', '2023-06-21 15:51:19', 19, '2023-06-21 21:21:19', NULL);
INSERT INTO `user_login_histories` VALUES (272, 18, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 21:21:40', '2023-06-21 21:30:26', 'Y', '2023-06-21 16:00:26', 18, '2023-06-21 21:30:26', NULL);
INSERT INTO `user_login_histories` VALUES (273, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 21:30:55', '2023-06-21 21:56:48', 'Y', '2023-06-21 16:26:48', 4, '2023-06-21 21:56:48', NULL);
INSERT INTO `user_login_histories` VALUES (274, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-21 22:13:02', NULL, 'Y', '2023-06-21 22:13:02', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (275, 4, 'Kolkata', '700045', '117.226.186.14', '2023-06-22 11:01:53', NULL, 'Y', '2023-06-22 11:01:53', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (276, 4, 'Dam Dam', '743247', '49.37.11.56', '2023-06-22 11:09:02', NULL, 'Y', '2023-06-22 11:09:02', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (277, 4, 'Doddaballapura', '560001', '49.205.141.193', '2023-06-22 11:36:27', NULL, 'Y', '2023-06-22 11:36:27', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (278, 4, 'Dam Dam', '743247', '49.37.11.56', '2023-06-22 14:13:29', NULL, 'Y', '2023-06-22 14:13:29', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (279, 9, 'Medinīpur', '721506', '117.227.96.214', '2023-06-22 15:29:50', '2023-06-22 15:33:04', 'Y', '2023-06-22 10:03:04', 9, '2023-06-22 15:33:04', NULL);
INSERT INTO `user_login_histories` VALUES (280, 9, 'Medinīpur', '721506', '117.227.96.214', '2023-06-22 15:35:57', '2023-06-22 15:38:05', 'Y', '2023-06-22 10:08:05', 9, '2023-06-22 15:38:05', NULL);
INSERT INTO `user_login_histories` VALUES (281, 21, 'Medinīpur', '721506', '117.227.96.214', '2023-06-22 15:39:21', NULL, 'Y', '2023-06-22 15:39:21', 21, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (282, 4, 'Bengaluru', '560002', '49.205.138.19', '2023-06-22 17:02:58', NULL, 'Y', '2023-06-22 17:02:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (283, 4, 'Dam Dam', '743247', '49.37.11.56', '2023-06-22 17:40:21', NULL, 'Y', '2023-06-22 17:40:21', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (284, 4, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 10:36:24', '2023-06-23 10:41:04', 'Y', '2023-06-23 05:11:04', 4, '2023-06-23 10:41:04', NULL);
INSERT INTO `user_login_histories` VALUES (285, 11, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 10:41:27', '2023-06-23 10:43:02', 'Y', '2023-06-23 05:13:02', 11, '2023-06-23 10:43:02', NULL);
INSERT INTO `user_login_histories` VALUES (286, 4, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 10:43:26', '2023-06-23 10:44:25', 'Y', '2023-06-23 05:14:25', 4, '2023-06-23 10:44:25', NULL);
INSERT INTO `user_login_histories` VALUES (287, 11, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 10:45:38', '2023-06-23 11:01:20', 'Y', '2023-06-23 05:31:20', 11, '2023-06-23 11:01:20', NULL);
INSERT INTO `user_login_histories` VALUES (288, 4, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 11:02:07', '2023-06-23 11:03:00', 'Y', '2023-06-23 05:33:00', 4, '2023-06-23 11:03:00', NULL);
INSERT INTO `user_login_histories` VALUES (289, 11, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 11:03:29', NULL, 'Y', '2023-06-23 11:03:29', 11, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (290, 18, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 11:11:09', NULL, 'Y', '2023-06-23 11:11:09', 18, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (291, 4, 'Kolkata', '700045', '117.227.55.243', '2023-06-23 15:10:31', '2023-06-23 22:16:50', 'Y', '2023-06-23 16:46:50', 4, '2023-06-23 22:16:50', NULL);
INSERT INTO `user_login_histories` VALUES (292, 11, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 15:18:27', '2023-06-24 10:31:01', 'Y', '2023-06-24 05:01:01', 11, '2023-06-24 10:31:01', NULL);
INSERT INTO `user_login_histories` VALUES (293, 4, 'Kolkata', '700045', '38.156.47.38', '2023-06-23 17:57:58', NULL, 'Y', '2023-06-23 17:57:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (294, 4, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 21:35:47', '2023-06-23 21:53:02', 'Y', '2023-06-23 16:23:02', 4, '2023-06-23 21:53:02', NULL);
INSERT INTO `user_login_histories` VALUES (295, 21, 'Port Blair', '744211', '117.227.52.192', '2023-06-23 21:39:08', NULL, 'Y', '2023-06-23 21:39:08', 21, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (296, 4, 'Bālurghāt', '794106', '115.187.54.4', '2023-06-23 21:52:02', NULL, 'Y', '2023-06-23 21:52:02', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (297, 4, 'Bengaluru', '560002', '49.205.138.19', '2023-06-23 22:00:38', NULL, 'Y', '2023-06-23 22:00:38', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (298, 4, 'Nelamangala', '560013', '49.205.141.35', '2023-06-24 10:16:20', '2023-06-24 10:35:17', 'Y', '2023-06-24 05:05:17', 4, '2023-06-24 10:35:17', NULL);
INSERT INTO `user_login_histories` VALUES (299, 11, 'Nelamangala', '560013', '49.205.141.35', '2023-06-24 10:31:19', NULL, 'Y', '2023-06-24 10:31:19', 11, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (300, 11, 'Nelamangala', '560013', '49.205.141.35', '2023-06-24 10:35:31', '2023-06-24 10:41:38', 'Y', '2023-06-24 05:11:38', 11, '2023-06-24 10:41:38', NULL);
INSERT INTO `user_login_histories` VALUES (301, 4, 'Nelamangala', '560013', '49.205.141.35', '2023-06-24 10:42:01', NULL, 'Y', '2023-06-24 10:42:01', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (302, 11, 'Nelamangala', '560013', '49.205.141.35', '2023-06-24 15:36:53', NULL, 'Y', '2023-06-24 15:36:53', 11, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (303, 4, 'Kolkata', '700099', '103.135.228.151', '2023-06-25 23:01:33', NULL, 'Y', '2023-06-25 23:01:33', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (304, 4, 'Kolkata', '700099', '103.135.228.151', '2023-06-26 08:08:54', NULL, 'Y', '2023-06-26 08:08:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (305, 4, 'Nelamangala', '560016', '49.205.136.15', '2023-06-26 09:37:34', NULL, 'Y', '2023-06-26 09:37:34', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (306, 4, 'Nelamangala', '560016', '49.205.136.15', '2023-06-26 13:30:54', '2023-06-26 13:35:32', 'Y', '2023-06-26 08:05:32', 4, '2023-06-26 13:35:32', NULL);
INSERT INTO `user_login_histories` VALUES (307, 4, 'Nelamangala', '560016', '49.205.136.15', '2023-06-26 13:37:55', NULL, 'Y', '2023-06-26 13:37:55', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (308, 4, 'Kolkata', '700006', '49.37.10.87', '2023-06-26 18:31:47', NULL, 'Y', '2023-06-26 18:31:47', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (309, 4, 'Kolkata', '700019', '49.37.11.110', '2023-06-27 09:35:57', NULL, 'Y', '2023-06-27 09:35:57', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (310, 4, 'Kolkata', '700019', '49.37.11.110', '2023-06-27 10:04:47', NULL, 'Y', '2023-06-27 10:04:47', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (311, 4, 'Kolkata', '700019', '49.37.11.110', '2023-06-27 12:19:34', NULL, 'Y', '2023-06-27 12:19:34', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (312, 4, 'Kolkata', '700019', '49.37.10.124', '2023-06-28 10:41:25', NULL, 'Y', '2023-06-28 10:41:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (313, 4, 'Kolkata', '700036', '49.37.8.148', '2023-06-29 10:01:26', NULL, 'Y', '2023-06-29 10:01:26', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (314, 4, 'Krishnanagar', '741164', '49.37.11.12', '2023-06-30 10:26:34', NULL, 'Y', '2023-06-30 10:26:34', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (315, 4, 'Krishnanagar', '741164', '49.37.11.12', '2023-06-30 17:45:16', NULL, 'Y', '2023-06-30 17:45:16', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (316, 4, 'Chākuliā', '832301', '49.37.10.95', '2023-07-03 09:44:43', NULL, 'Y', '2023-07-03 09:44:43', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (317, 4, 'Kolkata', '700015', '49.37.10.192', '2023-07-04 10:24:01', NULL, 'Y', '2023-07-04 10:24:01', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (318, 4, 'Kolkata', '700015', '49.37.10.192', '2023-07-04 19:39:56', NULL, 'Y', '2023-07-04 19:39:56', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (319, 4, 'Kolkata', '700015', '49.37.8.132', '2023-07-05 10:22:37', NULL, 'Y', '2023-07-05 10:22:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (320, 4, 'Kolkata', '700006', '49.37.10.57', '2023-07-06 14:25:38', NULL, 'Y', '2023-07-06 14:25:38', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (321, 4, 'Kolkata', '700006', '49.37.10.57', '2023-07-06 20:00:40', NULL, 'Y', '2023-07-06 20:00:40', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (322, 4, 'Dam Dam', '743247', '49.37.10.57', '2023-07-07 10:44:20', NULL, 'Y', '2023-07-07 10:44:20', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (323, 4, 'Kolkata', '700006', '49.37.8.186', '2023-07-10 10:03:51', NULL, 'Y', '2023-07-10 10:03:51', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (324, 4, 'Kolkata', '700037', '49.37.10.212', '2023-07-11 10:50:09', NULL, 'Y', '2023-07-11 10:50:09', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (325, 4, 'Dam Dam', '700048', '49.37.10.212', '2023-07-12 09:47:58', NULL, 'Y', '2023-07-12 09:47:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (326, 4, 'Dam Dam', '700048', '49.37.10.212', '2023-07-12 18:37:05', NULL, 'Y', '2023-07-12 18:37:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (327, 4, 'Dam Dam', '700048', '49.37.10.212', '2023-07-13 10:15:47', NULL, 'Y', '2023-07-13 10:15:47', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (328, 4, 'Dam Dam', '700048', '49.37.10.212', '2023-07-13 10:17:00', NULL, 'Y', '2023-07-13 10:17:00', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (329, 4, 'Dam Dam', '700048', '49.37.10.212', '2023-07-13 10:17:30', NULL, 'Y', '2023-07-13 10:17:30', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (330, 4, 'Kolkata', '700015', '49.37.11.46', '2023-07-14 09:38:12', NULL, 'Y', '2023-07-14 09:38:12', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (331, 4, 'Kolkata', '700015', '49.37.11.46', '2023-07-14 12:55:49', NULL, 'Y', '2023-07-14 12:55:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (332, 4, 'Dandeli', '581325', '117.255.37.178', '2023-07-16 11:55:10', NULL, 'Y', '2023-07-16 11:55:10', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (333, 4, 'Patna', '800001', '152.58.163.236', '2023-07-18 10:23:35', NULL, 'Y', '2023-07-18 10:23:35', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (334, 4, 'Karwar', '581305', '117.222.107.16', '2023-07-19 10:17:10', NULL, 'Y', '2023-07-19 10:17:10', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (335, 4, 'Sirsi', '581402', '61.1.210.29', '2023-07-21 08:38:24', NULL, 'Y', '2023-07-21 08:38:24', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (336, 4, 'Kolkata', '700006', '117.226.129.149', '2023-07-21 10:44:12', NULL, 'Y', '2023-07-21 10:44:12', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (337, 4, 'Patna', '800001', '152.58.163.222', '2023-07-21 10:52:15', NULL, 'Y', '2023-07-21 10:52:15', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (338, 4, 'Durgapur', '742187', '45.116.191.202', '2023-07-21 17:49:32', NULL, 'Y', '2023-07-21 17:49:32', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (339, 4, 'Sirsi', '581402', '61.1.210.174', '2023-07-21 22:58:26', NULL, 'Y', '2023-07-21 22:58:26', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (340, 4, 'Karwar', '581345', '117.255.34.36', '2023-07-23 19:50:40', NULL, 'Y', '2023-07-23 19:50:40', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (341, 4, 'Karwar', '581305', '117.222.105.160', '2023-07-26 09:21:03', NULL, 'Y', '2023-07-26 09:21:03', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (342, 4, 'Kolkata', '700019', '49.37.11.61', '2023-07-27 16:54:32', NULL, 'Y', '2023-07-27 16:54:32', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (343, 4, 'Kolkata', '700006', '49.37.11.61', '2023-07-28 10:37:28', NULL, 'Y', '2023-07-28 10:37:28', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (344, 4, 'Karwar', '581400', '117.222.109.179', '2023-07-30 15:29:27', NULL, 'Y', '2023-07-30 15:29:27', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (345, 4, 'Bengaluru', '560002', '49.205.141.36', '2023-08-01 10:05:47', NULL, 'Y', '2023-08-01 10:05:47', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (346, 4, 'Mumbai', '400070', '43.240.64.38', '2023-08-01 15:14:05', NULL, 'Y', '2023-08-01 15:14:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (347, 4, 'Hubli', '580118', '61.1.214.151', '2023-08-04 16:07:18', NULL, 'Y', '2023-08-04 16:07:18', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (348, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-07 14:53:15', NULL, 'Y', '2023-08-07 14:53:15', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (349, 4, 'Guntur', '522213', '175.101.68.55', '2023-08-10 11:46:54', NULL, 'Y', '2023-08-10 11:46:54', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (350, 4, 'Guntur', '522213', '175.101.68.55', '2023-08-13 13:10:17', NULL, 'Y', '2023-08-13 13:10:17', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (351, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-14 21:19:13', NULL, 'Y', '2023-08-14 21:19:13', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (352, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-15 11:01:37', NULL, 'Y', '2023-08-15 11:01:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (353, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-15 17:55:25', NULL, 'Y', '2023-08-15 17:55:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (354, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-16 07:55:41', NULL, 'Y', '2023-08-16 07:55:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (355, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-16 17:58:41', NULL, 'Y', '2023-08-16 17:58:41', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (356, 4, 'Siliguri', '734011', '152.58.163.71', '2023-08-16 18:08:06', NULL, 'Y', '2023-08-16 18:08:06', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (357, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-17 07:07:37', NULL, 'Y', '2023-08-17 07:07:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (358, 4, 'Durgapur', '742187', '103.102.121.137', '2023-08-17 10:52:01', NULL, 'Y', '2023-08-17 10:52:01', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (359, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-17 12:15:20', NULL, 'Y', '2023-08-17 12:15:20', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (360, 4, 'Siliguri', '734011', '152.58.163.70', '2023-08-17 12:56:15', NULL, 'Y', '2023-08-17 12:56:15', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (361, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-17 16:14:24', NULL, 'Y', '2023-08-17 16:14:24', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (362, 4, 'Kolkata', '700006', '117.226.134.175', '2023-08-18 01:03:46', NULL, 'Y', '2023-08-18 01:03:46', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (363, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-18 09:56:12', NULL, 'Y', '2023-08-18 09:56:12', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (364, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-18 15:32:01', NULL, 'Y', '2023-08-18 15:32:01', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (365, 4, 'Mācherla', '522426', '175.101.68.55', '2023-08-20 15:40:05', NULL, 'Y', '2023-08-20 15:40:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (366, 4, 'Hyderābād', '500001', '117.99.198.90', '2023-08-21 16:34:43', NULL, 'Y', '2023-08-21 16:34:43', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (367, 4, 'Hyderābād', '500001', '152.58.233.85', '2023-08-21 23:11:02', NULL, 'Y', '2023-08-21 23:11:02', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (368, 4, 'Kolkata', '700006', '49.37.41.252', '2023-08-22 10:26:23', NULL, 'Y', '2023-08-22 10:26:23', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (369, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-22 12:50:51', NULL, 'Y', '2023-08-22 12:50:51', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (370, 4, 'Mumbai', '400070', '43.240.64.38', '2023-08-22 15:38:26', NULL, 'Y', '2023-08-22 15:38:26', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (371, 4, 'Kolkata', '700006', '49.37.41.252', '2023-08-22 19:48:58', NULL, 'Y', '2023-08-22 19:48:58', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (372, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-23 09:12:05', NULL, 'Y', '2023-08-23 09:12:05', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (373, 4, 'Mumbai', '400070', '43.240.64.38', '2023-08-23 12:35:10', NULL, 'Y', '2023-08-23 12:35:10', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (374, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-23 15:03:37', NULL, 'Y', '2023-08-23 15:03:37', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (375, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-24 10:11:57', NULL, 'Y', '2023-08-24 10:11:57', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (376, 4, 'Kolkata', '700006', '49.37.41.4', '2023-08-24 12:04:19', NULL, 'Y', '2023-08-24 12:04:19', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (377, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-24 15:00:23', NULL, 'Y', '2023-08-24 15:00:23', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (378, 4, 'Kolkata', '700006', '49.37.41.4', '2023-08-24 16:50:43', NULL, 'Y', '2023-08-24 16:50:43', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (379, 4, 'Kolkata', '700006', '49.37.43.58', '2023-08-25 11:00:14', NULL, 'Y', '2023-08-25 11:00:14', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (380, 4, 'Bhattiprolu', '522256', '175.101.68.55', '2023-08-25 11:55:49', NULL, 'Y', '2023-08-25 11:55:49', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (381, 4, 'Raghudebbati', '711310', '49.37.43.113', '2023-08-28 11:00:29', NULL, 'Y', '2023-08-28 11:00:29', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (382, 4, 'Kolkata', '700046', '49.37.41.55', '2023-08-29 10:51:17', NULL, 'Y', '2023-08-29 10:51:17', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (383, 4, 'Kolkata', '700046', '49.37.41.55', '2023-08-30 09:46:34', NULL, 'Y', '2023-08-30 09:46:34', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (384, 4, 'Kolkata', '700043', '49.37.41.251', '2023-08-31 10:03:44', NULL, 'Y', '2023-08-31 10:03:44', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (385, 4, 'Kolkata', '700043', '49.37.41.251', '2023-08-31 20:36:25', NULL, 'Y', '2023-08-31 20:36:25', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (386, 4, 'Kolkata', '700043', '49.37.41.251', '2023-09-01 10:28:04', NULL, 'Y', '2023-09-01 10:28:04', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (387, 4, 'Kolkata', '700043', '49.37.43.161', '2023-09-04 10:47:07', NULL, 'Y', '2023-09-04 10:47:07', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (388, 4, 'Kolkata', '700045', '49.37.43.113', '2023-09-05 11:08:08', NULL, 'Y', '2023-09-05 11:08:08', 4, NULL, NULL);
INSERT INTO `user_login_histories` VALUES (389, 4, 'Kolkata', '700040', '49.37.43.113', '2023-09-06 10:26:20', NULL, 'Y', '2023-09-06 10:26:20', 4, NULL, NULL);

-- ----------------------------
-- Table structure for user_masters
-- ----------------------------
DROP TABLE IF EXISTS `user_masters`;
CREATE TABLE `user_masters`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` varchar(525) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_roles` int NOT NULL,
  `user_branch` int NOT NULL,
  `screen_lock` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `screen_lock_after_second` int NOT NULL,
  `auto_logout` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `auto_logout_after_second` int NOT NULL,
  `password_change` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_change_date` int NOT NULL,
  `max_no_of_bad_login_in_day` int NOT NULL,
  `otp_phone` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `otp_phone_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `otp_email` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `otp_email_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_supur_control` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'N',
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_masters
-- ----------------------------
INSERT INTO `user_masters` VALUES (4, 'dca024fb231d6873088b5cd2d511d3f4f02e4ee5f7c15f845ea175b17c61f13bfee225ea53ab115282d1dc553214e18eb203cd74a5927c872e06f21722ca291cxy73hwU8x693+2W7Ew0pt+X22ig/uhnXca5pvZxok/s=', 'ac3a71ebe5fd7a9631922b2e3c692560c98a859d1a35b5c213b6041fdbf86ca35a57daecfe18b6a427d4de571d5b7a0fb76b60616c1fc106413b6494fabfa32f3mqgADj1aHZZjPTKeJX1er9pmyzYQelpozGTy+RICIg=', 'Supercontrol2023', '9ae4516fb9c168b954ecdc39c217984c', '081bab70370f3e4ba7f4ca4e071374a2d176f013651032b40c659974c7114b1049b047ce683f87d49ca80e8580cad311ad5055202b0001133aaeb3667a5a88afn8x1PfvzglCgoodxMs6cR3HQIRRFdDt+ABjZ6legIMg=', 19, 6, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', '', 'Y', 'Y', '2023-02-16 21:03:30', 1, '2023-06-21 21:33:56', 4);
INSERT INTO `user_masters` VALUES (6, 'c4cac28786c108090d6a16e7d6ab015dcfc0d7e48094ebbcf2df5d8f15e9af2636e7c795ca68d394fbe2201b9893092dd3b39c791e6c9e475128bcda9869abb3SR0iDW2dddjgV2njut5dr1T2QYHwm8Sw97fOtiI6YIo=', '591007ae02b181a85ed82122820d6f670c59666ff346d0e6b5eafc12d3546a2811c1b2a47b6caebc5e0fec12395d6fa9f47859c172913c4847c0d9753ae78258ngb36cy6E2i80A295fEFWx0JzgwhiNK8C/StER+rtKo=', 'Suhrid Sarkar || suhrid.developer@gmail.combasak2023', 'e10adc3949ba59abbe56e057f20f883e', 'f7d54ec0cf62a608debd3e8f81da2b397d829c56e753fe68a9d099b4ad216150a280541be1c3845074091c7fce2005f0d3814e0f42938e8b4327f1b51d6570ab98luqlhjEexLPy89jIybOR4m+P901r6+P8F7yy8AZPw=', 16, 4, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'N', 'N', '2023-02-24 12:19:38', 4, '2023-06-20 14:02:19', 4);
INSERT INTO `user_masters` VALUES (7, '3bb259752d444108e7024e13cda7a303873b341bcec43c325a8e2d6ac4588817aa057c3e2f287142d27bde5ed8d283ffa75011f37c4e0e4c8a3d9363306f694eMfqZ8PKKWPkQk482Ugmby7VmMx5WJkAOh//ZalU/74k=', 'e3a4292bc6e9a32c0b2986023be061cd835854afcf86166b02f760bff6e4eee64d54d4dc91bfeb524a303e49e58351ad5a24c66cec12664de59daa73afc28d50BwE+WTc42Q0wSUs5WFJ0k7H8J9qUCVumhz+cCIFB8YM=', 'Loanapproval2023', 'e10adc3949ba59abbe56e057f20f883e', 'bb245dc4603ee86d24c5cf48cdeab40df154d40b3ca47b7836ffe19a5874e085bb87bd6cacd6c1f2a9cf5688abce881d28cb77d7e166286de99a839f69a1c6d8PUO415ViEuPbkIDD0hugui5DykUlULqP3QhCjCwmPBg=', 7, 1, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'N', 'N', '2023-06-07 18:26:57', 4, NULL, 0);
INSERT INTO `user_masters` VALUES (8, '3b6e021d68634248659e2dd61973ccbe9aa21d350869085845e1a15cff6e8ec51ed0bc97fc485804f6a4adeb3f0771889f04959a7f1c7e530d277141b2b651f8/SvIqVOBI/DREI1uxNAvsrDbbn8+o7RXkjALbRdumQw=', '3e7619cc58e498a266f9e62191bc1938f4eaaa9e31d4b2aa381621fc63de0365a94bab660fbbfbc5c061321d0a1cb5b43b2fd284f5f55e9776d8fa29fab8a534XRBk34QffhJqB8iYFjzkPJQ2JFyVA0BhfJN4QofhAnM=', 'Loanmanager2023', 'e10adc3949ba59abbe56e057f20f883e', '355bee636d68f170a922c22824b330206b0cde4ea12cb51b8c6b814881fbe94867b1a05e35e7b387106551a85a09357adc122a813cde02e1f28b4e4a711b59faM6t/3Nt16tjDlJ52sWVxN9BZ76y/ytjYtMwQ8kR7NUg=', 6, 1, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'N', 'N', '2023-06-07 19:38:53', 4, NULL, 0);
INSERT INTO `user_masters` VALUES (10, '0228ff315ae9eeaed2199d186ea454f6ebf4cdbb133c679b404fd5f932c08b3ed4111e22b7badd231fa380cbcd3d6574fc8f712d4915d6959a5a4990cc9987e0+zWSvDM4TrNzLMVwSLoR8yhMvaxlG55dto95mEy+TWs=', '276f59614511bcd9686170dfcb710fe4faf74bd62c08a7c72e086cc05168548a8a5cf4f771a3d1b447b5336648bfd17863347353ed5c0828944457bc057d7e88/y4FhM/XjV/P43t6BBtRNswyYZFmtRcsZ8WGewYvr1w=', 'Apitest2023', 'e10adc3949ba59abbe56e057f20f883e', '794034330ec1292ff428ceb1ab5beaed05f51574ff1d7a4368868eed0deff7deeb85fd6215379e2a37b5da9df064150e6453ab522f8819fffa3a209409a7397cUTUXces+70hBW5Xb0rZa5gg1K7G5qHJ3+nOpQ8k4SzQ=', 7, 1, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'N', 'N', '2023-06-08 11:27:51', 4, NULL, 0);
INSERT INTO `user_masters` VALUES (11, '2381d3763157e3a89d62f753c8523615ba318f677bc293823e17840fb7453e158e1b287239d2ac5279a9b2fe5e167188eb95cd7c605f5aa75ec06753dfd1e79dPQfdRPN21VoOUWi7kj0B8ta51+I7DfOssyei3M10ooY=', '89586b86ae734600e5009079c6560cedc95b8b522a414b187b76aaeeb4aacc93f88d88db32524baae8c065bba49af8e6e2ddf8c580701fae7ad0a479b390ec86mlNVXAsM/nLDt2icXUe1Lj/VAouJw+9yEALpqacyKQ8=', 'ANJI', 'e6e061838856bf47e1de730719fb2609', '698073e4c08dc9123478c628f6affd66ba147dd6c49012f3f59f3dd5ad4dfabb062df3027264335f7855fa6dc1f751e9b54bef0403882a85760edce7042846dfD2QuEsCaWUzp+/tVkis7HX+waGOhVu9MZ5L8SM6cLdk=', 12, 5, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-19 09:04:34', 4, '2023-06-24 10:27:31', 4);
INSERT INTO `user_masters` VALUES (12, '4ec862ecb09a0af096bd6b5df275ab103aba931c86db28d5c1b770545e6697a5ae5c04a5936c3759b96abc30a683a47350453ebb92e55cbe799619f06b13e7a19L9QO8SFYutMjZQVSg6yKkf/B8MaVl4hzGSm3nLh704=', '67f3872f7a95ddf8e26fd508b6738c79ff4507a4d917136065586c7091df982905d50a3490cdca842ec573b6d592a08ae4423eb1c5a708bced582b3df8c7cc8aF+Pdr3dEj5iOqj4hhJPoqsf1DetG0iaMBTZFbbon+qI=', 'niharika', 'e6e061838856bf47e1de730719fb2609', '62bffe55f3b7c6028c93742b950853dc275b187d8563dc615fc05ad1419a126745a2583f85ad5d0a15f1b3396f873a442de27e889bbc82074744b6d87c5ffb59P+9s3oxVzl6ebomjMYZPG3NL5OELwPZ45DsPQALcuvI=', 14, 5, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-19 09:05:27', 4, '2023-06-24 10:29:27', 4);
INSERT INTO `user_masters` VALUES (13, '886bb3a8eac9667576473e90981642101fb72845f6d7ff6be641949dad156cbb36c6c922054a0dce6c2761c91f98673ebc57194921edce2490973abc3f088c6eGeHn9U+OP233dsfzIgoexCxbmLYquborkYmprSegMzc=', '1d25145b364de65091a9e790cc6190328cbc98a0e786feb8e6740cc30b354fe06bb38bbeafdedbffd4ecea9fe89ff4ba6ea57bbe57dbf790796bec1524bf0257CYtVxVONMU9IYAZ6C77SFD3w6WkPX14Od2yDtq/s29c=', 'krishna', 'e6e061838856bf47e1de730719fb2609', 'd169cbb93d3efcf62bdc420e6d80c62309feaa00748c7de68c2c92dc13ea51c1e17601e0b901ada3ed102f8cee23f5bf6f3bd51cc113aeaa9ac613f8213ea51cJhR8zfRfBB3+G+jbN7eU5ZMG8D9oS2Af9EEndnkMhyE=', 19, 6, 'N', 0, 'N', 0, 'Y', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-21 09:45:40', 4, '2023-06-21 10:08:08', 4);
INSERT INTO `user_masters` VALUES (14, '6aad2eb1b17b3cb14b86a08ddd7f4a43e47add54f01f2cfe002776793d5ec754e9f0e94e89eb7d7a14650347571c6f7af17a0cbf8989d7f2fe36d292e22d2428jTmcvZ2PbukwlmNdrY37ZENyCNbymjlUPA3IKW3Z8O4=', 'c080bda10901fe7b5f7f9d018221d25f074cd3b056cd2c5ecbf6e2aba803776e1df2578224b8e188dd085bbf0e831696897f81cb43924134882da26b1cf86109fkknnaZtyBO31AFA2r5uV8jW7J2Gr7zqleOf3cLixcs=', 'chandrakala', 'e6e061838856bf47e1de730719fb2609', '92544fca6381dfc4add9e8a6b5b797e70e0894485e58841d52e7da1989d69800712ab29f0eb3b744491f88761f827a458f74c51c414a34308518c31599ae4192uAGKGEZXIgmltTEE2XZtT2paVUjlHLFYG4tShn1C2rI=', 18, 6, 'N', 0, 'N', 0, 'Y', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-21 09:48:31', 4, '2023-06-21 10:09:57', 4);
INSERT INTO `user_masters` VALUES (15, '1b498b7e1061243eb0f7b18ac4fff90eda35e74c0209c39d2abb1b81b1a6d94fba5b6f198982832d10d1d2b876d54943d7efb778440301e7735eec28b4aecdfe4yf1Pq/FnUyDK/bbLbN5qMDkn3BhA0rQbWaE/OjR8sk=', 'c9c076e97134075c530650913144369e492a09ff9d47a7d0f86daec4443d55243d8be3717c4414f178a79e2a8a200807e3973de0bd630ba88994d24b17ad38a9CGzfLybxJiWgQ+nRPiTKQG9EkKRAC3zMCdVKra4mzA8=', 'Meenakshi', 'e6e061838856bf47e1de730719fb2609', '558c5c29cb591b3d147516cbe5f922e5d9b86b907db019096467f114509c74132be403dcf5bb0b5389dd2dd22633b9d825236a1efd1bb085140b7f0282225739ef4439qLQ65ixXEP2VwVZOfVDjM9STOMKIuqpMVVhgI=', 17, 6, 'N', 0, 'N', 0, 'Y', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-21 09:51:47', 4, '2023-06-21 10:14:46', 4);
INSERT INTO `user_masters` VALUES (16, '4688d125ce51b4991d5f3dc799ef1d69e64ebb63eaa8c255984ebd97b36190ecd81c4820bea1af7fc458480bd649592a053256a0e4551ac208f483a2556b6dccWNcTs6HLlyPHU1fRZBt6foKk5PfSXGtOz/DrX3V+JWU=', '9cc2934994b47fdcb95dadccede0f37f79be3b522badcb6c432045859d8010774e74f325f13b831ae6944cdd1ee9cde69fa56ba08420eb5177dcac6c298cd03aPWxGN57nxuJ5N1sRYAulv4SWaPIAKuZc5QU32pVH6JU=', 'naveen', 'e6e061838856bf47e1de730719fb2609', 'b47afb89cc003651def0fb817dd177d41188037ef3ea27104911fd7482eacedb49c953642a0518370553949bbba46becb87133cf549a34ddf3c9e2cdb057b6f468qpDvRKe9Sq8yHQd1aTwDyETl3QAT/uU7pzfqdHTyU=', 16, 6, 'N', 0, 'N', 0, 'Y', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-21 09:52:41', 4, '2023-06-21 10:11:03', 4);
INSERT INTO `user_masters` VALUES (17, 'df2f86e2077a41b2cf715e2c429fe306cb4c26f539ba0baaec589755e793db4215507fc80796ad7b9a3a3f9df0467c6ebb0ebc045518c45277d77f7d8b1babe1U+1fQq3H8zsCAhKBfkRybfhDRfJWFZJAi5Vd++oIrMM=', '2be8bab4faeacf0362d08f9e14646b3445c5fab75818dcd9dde3bf02192c4943653f0ae8293e33347b1f8ceffe422c0ebbf53fc167747a836013fcb915c4a130v3Q0zg6+lBnFEnqoQ2hcSK+ik+ooJvDfjISvIebUR5g=', 'ganesh', 'e6e061838856bf47e1de730719fb2609', 'f97eaf846f1e0b55e626ba8209b61f0dcb1402236fa11e6a2a47c39eb58bfd077280769ff21a4a96c895e0ff3bb3b8be8261ef0d12b6db1305a95eaef55eec11olDSL1hxjSkFRh2p60vQtyPveVJj/57Gl6lyQuznOkE=', 15, 6, 'N', 0, 'N', 0, 'Y', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-21 09:53:16', 4, '2023-06-21 10:11:31', 4);
INSERT INTO `user_masters` VALUES (18, '59ad951e5685eecf0fc7c0b9fa5ad68e96a28c47280b2b4a21da161704fbf01ffdbfb909a6cac6383a5107e4f7702b091c48f1f5a5b382cbbbd5a152a5aafefac14ZsCrWF19znl81ekW07+XeJ/B/HXC/wWLTPJX0MjA=', 'e73afb9666a54c0191cc785927879827d3261c7fd2f9d03d4074e41c8739210d1806f356d17f5ca56b5ed27861c3c1c750841c8b4a526f9bbf85c61c8947756f5VPU/udmCsam3hMcFYldD4diZyVixS86ua2hyPHQQyU=', 'renuka', 'e6e061838856bf47e1de730719fb2609', '556d689ac67f1def646209eed66e21e082b7081e71d9d4ff6c59df615b5ee4ea3add9d983ae0e5918f11eefa3f557f919873c2e7b905c7af45fcc30e88b9839an+i/KVV0gH2KLVmFOePflrjgCw9PNHCkQysrUda0res=', 12, 4, 'N', 0, 'N', 0, 'Y', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-21 09:57:43', 4, '2023-06-21 10:17:34', 4);
INSERT INTO `user_masters` VALUES (19, 'c0afeebc46a87fc8bddbf5858107ab63994bdb0ad628f1b9b02fe0b3ef3244dcf67e94b80027dbedcf62e491699116770e45aa2cc84a944687a77b33e766c9d2ESD0POZPXT5T5bePHj3HBQnzTl8Jp6YRc2S4vHI6i0c=', '4eb41aa36922590fcc75b8b5adb1269fd055d98e268029c44294ef96580a3a5870816f48339016bcd1d543f6e021fb938adf65e44a4149a3398d5ac331e707damObPRK4MGbFV5/rXVZb31D+65Thcd9/bc3hzTbB4LaE=', 'rajeswari', 'e6e061838856bf47e1de730719fb2609', '3cf4dff5070239982a99600196708ee56ba3d064cfac0d753443b8f2794485e6ff26d9265ce2de1d837c69c3215a5db8fd91d1e0ed5ddf077a0a0a60b300020e5rMKFB9hP12a5loavEP16H6L143dH5vHCAsKOnNd+9Q=', 14, 4, 'N', 0, 'N', 0, 'Y', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-21 09:58:37', 4, '2023-06-21 10:18:12', 4);
INSERT INTO `user_masters` VALUES (20, '09d70aa45404cf8d99b55fab3f461a65d04b0f57a9d0f655a38905b6ed339c0fe6ffffa58715e517df403d904cf4f6f5e4ef425a55c5e3e9b95d0a5595189808Z8bzBcfV6J47S9jFeNUCbC914PLrgN+DAEiBELkJM8Q=', '81abdc4c400b485bbf857e018b7685f14aba436452f60ac9509ad140f00f5bdb818172c885a4b7444450587f30b9ed5fd8031da532baf118364251aaa7bed974zMCmK1OJR9VD0zaKRHCdZxJHB1ZTs4jzf++5gs8eaOQ=', 'raji', 'e10adc3949ba59abbe56e057f20f883e', 'e1cbbd9acd2f5329149c43cd7e8adf31dd3cd6f5ba1a71cdaf446ce4e22f3f8f76a161fcd3e4f64567aa2367b970efaecc4d4d9c320296465e4854127055aa90fUyMiG0mla0Rca/5liGcj0rQ1Wce82rUdurNfK/2W4o=', 12, 4, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'N', 'N', '2023-06-21 11:32:52', 4, NULL, 0);
INSERT INTO `user_masters` VALUES (21, 'bae57fb0317502f917fd6210ae771ae2199d67fd5ef7c7f69ebc9edb6ae6fe05c1c3a1497c674823789d8bc491c0f142075ec6bef3cf99de624bb38f41a6c7d9BFcofHMhRWYswKY0ijx2Q2pOcutzDYKW/VaGISJMnhM=', '12ec85fa62e86e2e3d620b1c598170321582b7aeae9228d1733f489420b27a9cafbefd63f342899f1d5cbdb304ed248d5e56c75a83275cc4454f20ac6d030453hx/QlQeU2HH/fefItGvuasTUb28Iw86fffwEEA19olA=', 'Branchmanager2023', 'e10adc3949ba59abbe56e057f20f883e', '3532c819abee88ad0fc7bb43e4193b13b38f24b5993ee3e878eaf6c1500ac959975d0ac71c10b70ef2c02b0f5a8361a07d49770769174fcc9f6c06925ad0cf91CPE0ucbbcLWjR+T+74ESODhHuKcM7MmxOqvnuNxfnzQ=', 14, 4, 'N', 0, 'N', 0, 'N', 0, 3, 'N', '', 'N', '', NULL, 'Y', 'N', '2023-06-22 15:35:46', 4, NULL, 0);

-- ----------------------------
-- Table structure for user_password_change_histories
-- ----------------------------
DROP TABLE IF EXISTS `user_password_change_histories`;
CREATE TABLE `user_password_change_histories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `password_changed_at` datetime NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_password_change_histories
-- ----------------------------
INSERT INTO `user_password_change_histories` VALUES (1, 4, '0000-00-00 00:00:00', 'Y', '2023-04-06 20:13:17', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (2, 13, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:08:08', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (3, 14, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:09:57', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (4, 15, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:10:33', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (5, 16, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:11:03', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (6, 17, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:11:31', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (7, 15, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:14:46', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (8, 12, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:15:38', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (9, 11, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:16:29', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (10, 18, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:17:34', 0, NULL, NULL);
INSERT INTO `user_password_change_histories` VALUES (11, 19, '0000-00-00 00:00:00', 'Y', '2023-06-21 10:18:12', 0, NULL, NULL);

-- ----------------------------
-- Table structure for user_role_changed_histories
-- ----------------------------
DROP TABLE IF EXISTS `user_role_changed_histories`;
CREATE TABLE `user_role_changed_histories`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NULL DEFAULT NULL,
  `user_current_role` int NULL DEFAULT NULL,
  `user_updated_role` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_role_changed_histories
-- ----------------------------
INSERT INTO `user_role_changed_histories` VALUES (1, NULL, NULL, 5, NULL, '2023-04-07 14:25:54', 0, NULL, NULL);
INSERT INTO `user_role_changed_histories` VALUES (2, NULL, NULL, 6, NULL, '2023-04-07 14:28:40', 0, NULL, NULL);
INSERT INTO `user_role_changed_histories` VALUES (3, 6, 6, 3, 'Y', '2023-04-07 15:02:06', 0, NULL, NULL);
INSERT INTO `user_role_changed_histories` VALUES (4, 4, 3, 19, 'Y', '2023-06-19 16:43:17', 0, NULL, NULL);
INSERT INTO `user_role_changed_histories` VALUES (5, 6, 3, 16, 'Y', '2023-06-20 14:02:19', 4, NULL, NULL);
INSERT INTO `user_role_changed_histories` VALUES (6, 11, 4, 12, 'Y', '2023-06-21 09:53:41', 4, NULL, NULL);
INSERT INTO `user_role_changed_histories` VALUES (7, 12, 3, 14, 'Y', '2023-06-21 09:56:44', 4, NULL, NULL);

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp ON UPDATE CURRENT_TIMESTAMP,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES (1, 'Super Admin', 'N', '2023-02-15 00:12:01', 1, NULL, 0);
INSERT INTO `user_roles` VALUES (2, 'Super Admin', 'N', '2023-02-15 00:16:02', 1, NULL, 0);
INSERT INTO `user_roles` VALUES (3, 'Super Admin', 'N', '2023-06-19 08:03:55', 1, '2023-02-14 19:47:03', 1);
INSERT INTO `user_roles` VALUES (4, 'Branch Manager', 'N', '2023-06-19 08:03:52', 1, NULL, 0);
INSERT INTO `user_roles` VALUES (5, 'Branch Asset Manager', 'N', '2023-06-19 08:03:49', 1, NULL, 0);
INSERT INTO `user_roles` VALUES (6, 'Loan Manager', 'N', '2023-06-19 08:03:46', 1, NULL, 0);
INSERT INTO `user_roles` VALUES (7, 'Loan Approval', 'N', '2023-06-19 08:03:39', 1, NULL, 0);
INSERT INTO `user_roles` VALUES (8, 'HR', 'N', '2023-06-19 08:03:36', 1, NULL, 0);
INSERT INTO `user_roles` VALUES (9, 'dasdasd', 'N', '2023-02-22 01:20:22', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (10, 'Demo Role 3', 'N', '2023-06-02 07:48:27', 4, '2023-06-02 13:13:49', 4);
INSERT INTO `user_roles` VALUES (11, 'Demo 111', 'N', '2023-06-02 07:49:25', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (12, 'Clerk', 'Y', '2023-06-19 13:34:17', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (13, 'Officer', 'Y', '2023-06-19 13:34:29', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (14, 'Branch Manager', 'Y', '2023-06-19 13:34:38', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (15, 'HO Loan Officer', 'Y', '2023-06-19 13:34:58', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (16, 'Credit Officer', 'Y', '2023-06-19 13:35:13', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (17, 'CEO', 'Y', '2023-06-19 13:35:23', 4, NULL, 0);
INSERT INTO `user_roles` VALUES (18, 'Business Committee', 'Y', '2023-06-19 08:10:50', 4, '2023-06-19 13:40:50', 4);
INSERT INTO `user_roles` VALUES (19, 'Board', 'Y', '2023-06-19 13:35:53', 4, NULL, 0);

-- ----------------------------
-- Table structure for user_wise_product_master
-- ----------------------------
DROP TABLE IF EXISTS `user_wise_product_master`;
CREATE TABLE `user_wise_product_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_type` int NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_wise_product_master
-- ----------------------------
INSERT INTO `user_wise_product_master` VALUES (1, 0, 3, 'Y', '2023-04-24 19:07:07', 4, '2023-04-24 13:37:07', NULL);
INSERT INTO `user_wise_product_master` VALUES (2, 0, 5, 'Y', '2023-06-22 12:02:40', 4, '2023-06-22 06:32:40', NULL);

-- ----------------------------
-- Table structure for user_wise_product_master_map
-- ----------------------------
DROP TABLE IF EXISTS `user_wise_product_master_map`;
CREATE TABLE `user_wise_product_master_map`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `main_id` int NULL DEFAULT NULL,
  `employee_id` int NULL DEFAULT NULL,
  `upper_limit` int NULL DEFAULT NULL,
  `lower_limit` int NULL DEFAULT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` datetime NULL DEFAULT current_timestamp,
  `created_by` int NULL DEFAULT NULL,
  `updated_at` datetime NULL DEFAULT current_timestamp,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_wise_product_master_map
-- ----------------------------
INSERT INTO `user_wise_product_master_map` VALUES (1, 1, 6, 10000, 0, 'N', '2023-04-24 19:07:07', 4, '2023-04-24 13:37:07', NULL);
INSERT INTO `user_wise_product_master_map` VALUES (2, 2, 18, 500000, 1, 'Y', '2023-06-22 12:02:40', 4, '2023-06-22 06:32:40', NULL);
INSERT INTO `user_wise_product_master_map` VALUES (3, 2, 16, 1000000, 500001, 'Y', '2023-06-22 12:02:40', 4, '2023-06-22 06:32:40', NULL);

-- ----------------------------
-- Table structure for workflow
-- ----------------------------
DROP TABLE IF EXISTS `workflow`;
CREATE TABLE `workflow`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `version_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `product_type` int NULL DEFAULT NULL,
  `product` int NULL DEFAULT NULL,
  `product_limet_id` int NULL DEFAULT NULL,
  `branch` int NULL DEFAULT NULL,
  `is_use` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'N',
  `is_editable` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Y',
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of workflow
-- ----------------------------
INSERT INTO `workflow` VALUES (1, 'Version 1', NULL, NULL, NULL, NULL, 'N', 'Y', 'N', '2023-06-05 13:31:25', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (2, 'Version 2', NULL, NULL, NULL, NULL, 'N', 'Y', 'N', '2023-06-05 13:34:00', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (3, 'Version 3', NULL, NULL, NULL, NULL, 'N', 'Y', 'N', '2023-06-05 13:34:19', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (4, 'Version 5', 11, 3, 12, 1, 'N', 'Y', 'N', '2023-06-12 19:30:59', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (8, 'Version test', 11, 3, 12, 1, 'N', 'Y', 'N', '2023-06-14 16:45:09', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (9, 'Version testg', 11, 3, 12, 1, 'N', 'Y', 'N', '2023-06-14 16:58:13', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (10, 'Demo', 11, 3, 12, 1, 'N', 'Y', 'N', '2023-06-14 19:26:41', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (11, 'Demo 1', 11, 3, 12, 1, 'N', 'Y', 'N', '2023-06-14 19:27:32', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (12, 'Version test demo', 11, 3, 12, 1, 'N', 'Y', 'N', '2023-06-16 18:59:24', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (13, 'Version test laila', 11, 3, 12, 1, 'N', 'Y', 'N', '2023-06-16 19:37:29', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (14, 'Version 2', 11, 5, 14, 4, 'N', 'Y', 'N', '2023-06-21 13:21:22', 4, '2023-06-22 15:36:47', 4);
INSERT INTO `workflow` VALUES (15, 'Version 3', 11, 5, 14, 4, 'N', 'Y', 'N', '2023-06-23 20:15:28', 4, NULL, NULL);
INSERT INTO `workflow` VALUES (16, 'New Version', 11, 5, 14, 6, 'N', 'Y', 'N', '2023-06-23 21:44:49', 4, '2023-06-24 10:17:45', 4);
INSERT INTO `workflow` VALUES (17, 'Personal Loans - Version 1', 11, 5, 14, 6, 'N', 'Y', 'Y', '2023-06-24 10:30:16', 4, '2023-06-26 11:11:35', 4);
INSERT INTO `workflow` VALUES (18, 'Default', 11, 5, 14, 6, 'Y', 'N', 'Y', '2023-07-27 17:19:28', 4, NULL, NULL);

-- ----------------------------
-- Table structure for workflow_role_map
-- ----------------------------
DROP TABLE IF EXISTS `workflow_role_map`;
CREATE TABLE `workflow_role_map`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `workflow_id` bigint NOT NULL,
  `role_id` bigint NOT NULL,
  `user_id` int NULL DEFAULT NULL,
  `indexing` int NOT NULL,
  `is_active` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int NOT NULL,
  `updated_at` datetime NULL DEFAULT NULL,
  `updated_by` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of workflow_role_map
-- ----------------------------
INSERT INTO `workflow_role_map` VALUES (1, 1, 7, NULL, 1, 'N', '2023-06-05 13:31:25', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (2, 2, 7, NULL, 1, 'Y', '2023-06-05 13:34:00', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (3, 2, 6, NULL, 2, 'Y', '2023-06-05 13:34:00', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (4, 3, 7, NULL, 1, 'N', '2023-06-05 13:34:19', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (5, 3, 6, NULL, 2, 'N', '2023-06-05 13:34:19', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (6, 3, 4, NULL, 3, 'N', '2023-06-05 13:34:19', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (7, 4, 3, 4, 1, 'Y', '2023-06-12 19:30:59', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (8, 4, 4, 9, 2, 'Y', '2023-06-12 19:30:59', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (9, 5, 3, 4, 1, 'Y', '2023-06-13 14:08:03', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (12, 8, 3, 4, 1, 'N', '2023-06-14 16:45:09', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (13, 9, 3, 4, 1, 'Y', '2023-06-14 16:58:13', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (14, 10, 3, 4, 1, 'Y', '2023-06-14 19:26:41', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (15, 10, 4, 9, 2, 'Y', '2023-06-14 19:26:42', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (16, 11, 3, 4, 1, 'Y', '2023-06-14 19:27:32', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (17, 12, 3, 4, 1, 'Y', '2023-06-16 18:59:24', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (18, 13, 3, 4, 1, 'N', '2023-06-16 19:37:29', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (19, 13, 4, 9, 2, 'N', '2023-06-16 19:37:29', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (20, 14, 12, 18, 1, 'N', '2023-06-21 13:21:22', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (21, 14, 14, 19, 2, 'N', '2023-06-21 13:21:22', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (22, 14, 12, 18, 1, 'N', '2023-06-22 15:36:47', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (23, 14, 14, 21, 2, 'N', '2023-06-22 15:36:47', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (24, 15, 14, 19, 1, 'N', '2023-06-23 20:15:28', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (25, 15, 12, 18, 2, 'N', '2023-06-23 20:15:29', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (26, 16, 12, 18, 1, 'N', '2023-06-23 21:44:49', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (27, 16, 14, 21, 2, 'N', '2023-06-23 21:44:49', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (28, 16, 14, 21, 1, 'N', '2023-06-24 10:17:45', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (29, 16, 12, 18, 2, 'N', '2023-06-24 10:17:45', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (30, 16, 15, 17, 3, 'N', '2023-06-24 10:17:45', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (31, 17, 12, 11, 1, 'N', '2023-06-24 10:30:16', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (32, 17, 14, 12, 2, 'N', '2023-06-24 10:30:16', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (33, 17, 14, 12, 1, 'N', '2023-06-24 10:30:50', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (34, 17, 12, 11, 2, 'N', '2023-06-24 10:30:50', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (35, 17, 15, 17, 3, 'N', '2023-06-24 10:30:50', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (36, 17, 16, 16, 4, 'N', '2023-06-24 10:30:50', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (37, 17, 18, 14, 5, 'N', '2023-06-24 10:30:50', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (38, 17, 19, 13, 6, 'N', '2023-06-24 10:30:50', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (39, 17, 19, 13, 1, 'N', '2023-06-26 11:07:39', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (40, 17, 18, 14, 2, 'N', '2023-06-26 11:07:39', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (41, 17, 16, 16, 3, 'N', '2023-06-26 11:07:39', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (42, 17, 15, 17, 4, 'N', '2023-06-26 11:07:39', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (43, 17, 12, 11, 5, 'N', '2023-06-26 11:07:39', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (44, 17, 14, 12, 6, 'N', '2023-06-26 11:07:39', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (45, 17, 12, 11, 7, 'N', '2023-06-26 11:07:39', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (46, 17, 12, 11, 1, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (47, 17, 14, 12, 2, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (48, 17, 12, 11, 3, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (49, 17, 15, 17, 4, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (50, 17, 16, 16, 5, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (51, 17, 18, 14, 6, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (52, 17, 19, 13, 7, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (53, 17, 16, 16, 8, 'Y', '2023-06-26 11:11:35', 4, NULL, NULL);
INSERT INTO `workflow_role_map` VALUES (54, 18, 19, 4, 1, 'Y', '2023-07-27 17:19:28', 4, NULL, NULL);

-- ----------------------------
-- Procedure structure for sp_dashboard_count
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_dashboard_count`;
delimiter ;;
CREATE PROCEDURE `sp_dashboard_count`()
BEGIN
	SELECT 
    	(SELECT COUNT(*) FROM user_masters WHERE is_active = 'Y') AS user_master,
        (SELECT COUNT(*) FROM customer_master WHERE is_active = 'Y') AS customer_master,
        (SELECT COUNT(*) FROM branch_masters WHERE is_active = 'Y') AS branch_master
    FROM user_masters LIMIT 1; 
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_dynamic_query
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_dynamic_query`;
delimiter ;;
CREATE PROCEDURE `sp_dynamic_query`(IN `table_name` VARCHAR(255), IN `query` TEXT, IN `operation_name` VARCHAR(255))
BEGIN

	IF operation_name = "CREATE TABLE" THEN
        SET @QRY = CONCAT("DROP TABLE IF EXISTS ", table_name); 
        PREPARE stmt FROM @QRY;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
    END IF;
    
    SET @QRY = query;
    PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
	
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_loan_count
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_loan_count`;
delimiter ;;
CREATE PROCEDURE `sp_loan_count`(IN `month` INT, IN `year` INT)
BEGIN
	DECLARE query VARCHAR(500) DEFAULT '';
	DECLARE monthQuery VARCHAR(500) DEFAULT '';
    DECLARE yearQuery VARCHAR(500) DEFAULT '';
	
    IF month<>0 OR month<>'' THEN
        SET monthQuery = CONCAT("AND MONTH(`created_at`) in (", month, ")");
    ELSE
        SET monthQuery = ' ';
    END IF;
    
    IF year<>0 OR year<>'' THEN
        SET yearQuery = CONCAT("AND YEAR(`created_at`) in (", year, ")");
    ELSE
        SET yearQuery = ' ';
    END IF;
    
    SET @QRY = CONCAT("SELECT 

            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE verify_statas = 'P' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS pending_loan,


            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE verify_statas = 'A' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS approve_loan,
            
      		
            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE verify_statas = 'R' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS reject_loan
            
            
        FROM loan_form_data LIMIT 1");

	PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_lone_ecm_count
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_lone_ecm_count`;
delimiter ;;
CREATE PROCEDURE `sp_lone_ecm_count`(IN `month` INT, IN `year` INT)
BEGIN
	DECLARE query VARCHAR(500) DEFAULT '';
	DECLARE monthQuery VARCHAR(500) DEFAULT '';
    DECLARE yearQuery VARCHAR(500) DEFAULT '';
	
    IF month<>0 OR month<>'' THEN
        SET monthQuery = CONCAT("AND MONTH(`created_at`) in (", month, ")");
    ELSE
        SET monthQuery = ' ';
    END IF;
    
    IF year<>0 OR year<>'' THEN
        SET yearQuery = CONCAT("AND YEAR(`created_at`) in (", year, ")");
    ELSE
        SET yearQuery = ' ';
    END IF;
    
    SET @QRY = CONCAT("SELECT 

            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE product_type = '11' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS lone_account,


            (SELECT 
                count(*) 
            FROM loan_form_data 
            WHERE product_type = '13' 
            AND is_active = 'Y'", monthQuery, " ", yearQuery, ") AS deposit_account
            
        FROM loan_form_data LIMIT 1");

	PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END
;;
delimiter ;

-- ----------------------------
-- Procedure structure for sp_report
-- ----------------------------
DROP PROCEDURE IF EXISTS `sp_report`;
delimiter ;;
CREATE PROCEDURE `sp_report`(IN `status_data` VARCHAR(255), IN `customerdata` VARCHAR(255), IN `productsdata` VARCHAR(255), IN `branchdata` VARCHAR(255), IN `to_date` VARCHAR(255), IN `form_date` VARCHAR(255))
BEGIN
    DECLARE status_query VARCHAR(500) DEFAULT '';
    DECLARE customer_query VARCHAR(500) DEFAULT '';
    DECLARE product_query VARCHAR(500) DEFAULT '';
    DECLARE branch_query VARCHAR(500) DEFAULT '';
    DECLARE to_date_query VARCHAR(500) DEFAULT '';
    DECLARE form_date_query VARCHAR(500) DEFAULT '';

    IF status_data <> "" THEN
        SET status_query = CONCAT(" AND loan_form_data.verify_statas = '", status_data, "' ");
    ELSE
        SET status_query = " ";
    END IF;

    IF customerdata <> "" THEN
        SET customer_query = CONCAT(" AND loan_form_data.customer_id = ", customerdata, " ");
    ELSE
        SET customer_query = " ";
    END IF;

    IF productsdata <> "" THEN
        SET product_query = CONCAT(" AND loan_form_data.product_id = ", productsdata, " ");
    ELSE
        SET product_query = " ";
    END IF;

    IF branchdata <> "" THEN
        SET branch_query = CONCAT(" AND loan_form_data.branch = ", branchdata, " ");
    ELSE
        SET branch_query = " ";
    END IF;

    IF to_date <> "" AND form_date <> "" THEN
        SET to_date_query = CONCAT(" AND DATE(loan_form_data.created_at) BETWEEN '", form_date, "' AND '", to_date, "' ");
    ELSE
        IF to_date <> "" THEN
            SET to_date_query = CONCAT(" AND DATE(loan_form_data.created_at) = '", to_date, "' ");
        ELSE
            SET to_date_query = " ";
        END IF;

        IF form_date <> "" THEN
            SET form_date_query = CONCAT(" AND DATE(loan_form_data.created_at) = '", form_date, "' ");
        ELSE
            SET form_date_query = " ";
        END IF;
    END IF;

    SET @QRY = CONCAT("
                SELECT 
                    (SELECT COUNT(*) FROM loan_form_data WHERE is_active = 'Y') as recordsTotal,

                    (
                        SELECT COUNT(*) FROM loan_form_data 
                        LEFT JOIN customer_master
                        ON customer_master.id = loan_form_data.customer_id
                        WHERE loan_form_data.is_active = 'Y'", 
                        status_query, 
                        customer_query, 
                        product_query, 
                        branch_query, 
                        to_date_query, 
                        form_date_query,"
                    ) as recordsFiltered,

                    loan_form_data.*, 
                    customer_master.account_number, 
                    customer_master.de_dupe_first_name, 
                    customer_master.de_dupe_last_name,
                    customer_master.account_number
                FROM loan_form_data
                LEFT JOIN customer_master
                ON customer_master.id = loan_form_data.customer_id
                WHERE loan_form_data.is_active = 'Y' ", 
                status_query, 
                customer_query, 
                product_query, 
                branch_query, 
                to_date_query, 
                form_date_query, 
                " ORDER BY loan_form_data.id DESC");
	-- SELECT @QRY;
    PREPARE stmt FROM @QRY;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END
;;
delimiter ;

SET FOREIGN_KEY_CHECKS = 1;
