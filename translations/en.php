<?php
/**
* Verifone e-commerce PrestaShop Module
*
* Feel free to contact Verifone e-commerce at support@paybox.com for any
* question.
*
* LICENSE: This source file is subject to the version 3.0 of the Open
* Software License (OSL-3.0) that is available through the world-wide-web
* at the following URI: http://opensource.org/licenses/OSL-3.0. If
* you did not receive a copy of the OSL-3.0 license and are unable
* to obtain it through the web, please send a note to
* support@paybox.com so we can mail you a copy immediately.
*
*  @category  Module / payments_gateways
*  @version   2.2.2
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*/

global $_MODULE;
$_MODULE = array();
$_MODULE['<{epayment}prestashop>epayment_e571660f8510857034449ed2be25a09d'] = 'In one integration, offer many payment methods, get a customized secure payment page, multi-lingual and multi-currency and offer debit on delivery or in 3 installments without charges for your customers.';
$_MODULE['<{epayment}prestashop>epayment_0ee8708cdd961e50236ac98a73a540a9'] = 'card in 3 times without fees';
$_MODULE['<{epayment}prestashop>epayment_a0d09826326fd385f6ceb17442f290de'] = 'Error when making capture request';
$_MODULE['<{epayment}prestashop>epayment_870876b81ce1ccdcc89cc6ed60a17079'] = 'Payment was authorized by Verifone e-commerce.';
$_MODULE['<{epayment}prestashop>epayment_f9a7d407e3bc8ff4f58a603ac6791534'] = 'Payment was authorized and captured by Verifone e-commerce.';
$_MODULE['<{epayment}prestashop>epayment_9642f2c8edb4d9eeedb4920510149649'] = 'First payment capture of %s %s done.';
$_MODULE['<{epayment}prestashop>epayment_04049698722ebe1f74d01486f590e74a'] = 'Next payments will be:';
$_MODULE['<{epayment}prestashop>epayment_ec8220c78c21c7c354575b0aa278f64e'] = 'Recurring payment is approved';
$_MODULE['<{epayment}prestashop>epayment_058e57bbd968821f6507f057d1755747'] = 'Invalid IPN call for recurring payment';
$_MODULE['<{epayment}prestashop>epayment_9e8e970db6f2d952f35ef77ea79f91cc'] = 'Second payment capture of %s %s done.';
$_MODULE['<{epayment}prestashop>epayment_85c2e4a36adaab3a7fc09ffd3f8f7d1d'] = 'Next payment will be:';
$_MODULE['<{epayment}prestashop>epayment_af034a2c7d1287d76112b32d5ae38809'] = 'Third payment capture of %s %s done.';
$_MODULE['<{epayment}prestashop>epayment_1201e519d24ce94d39a2707f355d8740'] = 'No more capture is pending.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_b23e58f2b15af641740851a70f5f4f1f'] = 'See also:';
$_MODULE['<{epayment}prestashop>payboxadminconfig_254f642527b45bc260048e30704edb39'] = 'Configuration';
$_MODULE['<{epayment}prestashop>payboxadminconfig_3225a10b07f1580f10dee4abc3779e6c'] = 'Parameters';
$_MODULE['<{epayment}prestashop>payboxadminconfig_cd494d76449d5dfe0c0adfb2f3447761'] = 'Contracts';
$_MODULE['<{epayment}prestashop>payboxadminconfig_0ba29c6a1afacf586b03a26162c72274'] = 'Environment';
$_MODULE['<{epayment}prestashop>payboxadminconfig_0cbc6611f5540bd0809a388dc95a615b'] = 'Test';
$_MODULE['<{epayment}prestashop>payboxadminconfig_756d97bb256b8580d4d71ee0c547804e'] = 'Production';
$_MODULE['<{epayment}prestashop>payboxadminconfig_78838b09628efceff97df397cf4cf905'] = 'In test mode your payments will not be sent to the bank.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_fb9696953011b5d2a699563e7f8fa867'] = 'Verifone e-commerce subscribed solution';
$_MODULE['<{epayment}prestashop>payboxadminconfig_ffa86aa3d2493ff574c31563919a086c'] = 'To get your password, subscribe to the appropriate Verifone e-commerce option.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_e73be65b31bc5e4c678a8b566f4d43e0'] = 'Verifone e-commerce Back-Office password';
$_MODULE['<{epayment}prestashop>payboxadminconfig_5f08ab58c9e23dd04395c8ec9a5b0480'] = 'Type of payment';
$_MODULE['<{epayment}prestashop>payboxadminconfig_43f6615bbb2c40a5306ff804094420b1'] = 'Immediate';
$_MODULE['<{epayment}prestashop>payboxadminconfig_4ed71db54748b36eeb398876b0c747ac'] = 'Deferred';
$_MODULE['<{epayment}prestashop>payboxadminconfig_9be2a48d340caa59d782d9100c73ae49'] = 'Debit on delivery';
$_MODULE['<{epayment}prestashop>payboxadminconfig_e02c1e569a6bb98e38c64b0a076b385e'] = 'Differed payment day';
$_MODULE['<{epayment}prestashop>payboxadminconfig_d30514488db93c2dd254168d89845941'] = 'Status after payment';
$_MODULE['<{epayment}prestashop>payboxadminconfig_edfb5491566f6e1a441ab2519e926297'] = 'Order status if payment accepted';
$_MODULE['<{epayment}prestashop>payboxadminconfig_80de3105386c2fa35535da07d3959cf9'] = 'Status triggering capture';
$_MODULE['<{epayment}prestashop>payboxadminconfig_0be29a0079043500478eeb4ce33bbe99'] = 'Automatic capture of payment when the order\'s status changes to this state or only using the manual capture button.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_0dd894b3938f858550a14e58d69371a5'] = 'Activate 3-D Secure';
$_MODULE['<{epayment}prestashop>payboxadminconfig_6777bff2216a436f3a6b4b747ddcdeb3'] = 'No';
$_MODULE['<{epayment}prestashop>payboxadminconfig_8c9515933afdb1fef5576f9762d46fc0'] = 'Yes';
$_MODULE['<{epayment}prestashop>payboxadminconfig_d11fd4c8f5fe958762354b8a25929977'] = 'Warning : your bank may enforce 3-D Secure. Make sure your set up is coherent with your Bank, Verifone e-commerce and PrestaShop';
$_MODULE['<{epayment}prestashop>payboxadminconfig_321f05a33783b5041bb4fb5421e037f5'] = 'Make sure that the contract signed with your bank allows 3-D Secure before proceeding with setup.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_7f8a5be95e99a1ea28a55035c43c6f00'] = 'Minimum order\'s amount 3-D Secure';
$_MODULE['<{epayment}prestashop>payboxadminconfig_969a50589f54b6bcad0b4802ef5233f9'] = 'Leave empty for all payments using the 3-D Secure authentication';
$_MODULE['<{epayment}prestashop>payboxadminconfig_e210477743d81dcd83a5fa685e20fd9a'] = 'Payment in three installments';
$_MODULE['<{epayment}prestashop>payboxadminconfig_405b68b3a85d209434cab0a35569c9a4'] = 'Make sure the solution is activated with Verifone e-commerce prior to setting.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_528e715852c62e5b2d82a6d51e34709a'] = 'Minimum order\'s amount for 3 installments payment ';
$_MODULE['<{epayment}prestashop>payboxadminconfig_7fa99f27afd2bbaef84c4ab4e7f114aa'] = 'Leave blank if there is no minimum order';
$_MODULE['<{epayment}prestashop>payboxadminconfig_571f4a950ba77153f2d6abc85f57c61c'] = 'Status after payment 1 and 2';
$_MODULE['<{epayment}prestashop>payboxadminconfig_f3069433a4a7096ccf7a56aebfcc8bbd'] = 'Status after last payment';
$_MODULE['<{epayment}prestashop>payboxadminconfig_d4dccb8ca2dac4e53c01bd9954755332'] = 'Save settings';
$_MODULE['<{epayment}prestashop>payboxadminconfig_93465c17406ed4dde0998bdcc5f9fde4'] = 'Add new payment method';
$_MODULE['<{epayment}prestashop>payboxadminconfig_81c12ea1048409730bd99c7f2cf1fb3b'] = 'Warning : Check that the chosen means of payment have been previously configured by Verifone e-commerce';
$_MODULE['<{epayment}prestashop>payboxadminconfig_b021df6aac4654c454f46c77646e745f'] = 'Label';
$_MODULE['<{epayment}prestashop>payboxadminconfig_4d3d769b812b6faa6b76e1a8abaece2d'] = 'Active';
$_MODULE['<{epayment}prestashop>payboxadminconfig_f7d8604e6cd6465ab9943900e8724d04'] = 'This method allows';
$_MODULE['<{epayment}prestashop>payboxadminconfig_db687137cec26f4c0a93e2d8f520e43e'] = 'Deferred payment';
$_MODULE['<{epayment}prestashop>payboxadminconfig_76f0ed934de85cc7131910b32ede7714'] = 'Refund';
$_MODULE['<{epayment}prestashop>payboxadminconfig_036e6f9b56a5c19c9c6cb35e5c5b119f'] = 'Paid immediatly';
$_MODULE['<{epayment}prestashop>payboxadminconfig_f2a6c498fb90ee345d997f888fce3b18'] = 'Delete';
$_MODULE['<{epayment}prestashop>payboxadminconfig_21f671ea203c9b6eb1fcdee188105e38'] = 'Are you sure ? do you want delete this card ?';
$_MODULE['<{epayment}prestashop>payboxadminconfig_abbef19851e1dc4495a522b6e575b338'] = 'Status after Kwixo payment';
$_MODULE['<{epayment}prestashop>payboxadminconfig_08ac22ed618bea5447cb4638e6938cac'] = 'Kwixo configuration';
$_MODULE['<{epayment}prestashop>payboxadminconfig_93390930550e0b8fa85206312ba938ce'] = 'Choose a type...';
$_MODULE['<{epayment}prestashop>payboxadminconfig_b16c6b201b9dea0dba4c5214e584d5a9'] = 'Category Detail';
$_MODULE['<{epayment}prestashop>payboxadminconfig_52a114462b78de8a2ddca5ab922721d3'] = 'Please select a type for each category of your shop';
$_MODULE['<{epayment}prestashop>payboxadminconfig_3adbdb3ac060038aa0e6e6c138ef9873'] = 'Category';
$_MODULE['<{epayment}prestashop>payboxadminconfig_7fb04f327e2e2d4612e9a18f1a59109e'] = 'Category type';
$_MODULE['<{epayment}prestashop>payboxadminconfig_0daea7a9a06d320f6334e5a226e2cc2d'] = 'Choose default type...';
$_MODULE['<{epayment}prestashop>payboxadminconfig_b04ad61ad875f6e7149fdd51c2e60ce2'] = 'Choose a carrier type...';
$_MODULE['<{epayment}prestashop>payboxadminconfig_e31dce321c6baa24f100df5fbbb4541e'] = 'Standard shipping';
$_MODULE['<{epayment}prestashop>payboxadminconfig_7b97ec861872784c43209064dd060161'] = 'Express shipping';
$_MODULE['<{epayment}prestashop>payboxadminconfig_84a4ee79ed85180a743340dceb2f98d1'] = 'Carrier Detail';
$_MODULE['<{epayment}prestashop>payboxadminconfig_f29f3f689a8a652a58669f60ab68aa50'] = 'Please select a carrier type for each carrier use on your shop';
$_MODULE['<{epayment}prestashop>payboxadminconfig_914419aa32f04011357d3b604a86d7eb'] = 'Carrier';
$_MODULE['<{epayment}prestashop>payboxadminconfig_fecb07f7ab46e23e9b520a9a9af7b97b'] = 'Carrier Type';
$_MODULE['<{epayment}prestashop>payboxadminconfig_44877c6aa8e93fa5a91c9361211464fb'] = 'Speed';
$_MODULE['<{epayment}prestashop>payboxadminconfig_e807d3ccf8d24c8c1a3d86db5da78da8'] = 'Days';
$_MODULE['<{epayment}prestashop>payboxadminconfig_f99af4647ea6dabfc5ee71a37388d2b4'] = 'This form allows you to add a new payment method. Don\'t use it unless Verifone e-commerce Support asks you to. Verifone e-commerce manual must be used to find valid settings.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_913fabccd3da6fd029f4f7c76754f412'] = 'Card Label';
$_MODULE['<{epayment}prestashop>payboxadminconfig_97bcfa87ecaf288688598f7998a88455'] = 'Display to order page';
$_MODULE['<{epayment}prestashop>payboxadminconfig_019e4459ffcf423188fab02c60f38a1a'] = 'PBX_TYPEPAIEMENT';
$_MODULE['<{epayment}prestashop>payboxadminconfig_c5553705ad7d99ed8871c66efac948b6'] = 'See Verifone e-commerce manual for allowed values';
$_MODULE['<{epayment}prestashop>payboxadminconfig_749e8b120e4e0f6af3461906b15099c4'] = 'PBX_TYPECARTE';
$_MODULE['<{epayment}prestashop>payboxadminconfig_8c2857a9ad1d8f31659e35e904e20fa6'] = 'Logo';
$_MODULE['<{epayment}prestashop>payboxadminconfig_d7f24700d7522ea794b9f0fcb690e0d8'] = 'Paid shipping';
$_MODULE['<{epayment}prestashop>payboxadminconfig_217c01a08bee4c2fa33d59a6ddc69806'] = '3-D Secure';
$_MODULE['<{epayment}prestashop>payboxadminconfig_aa7f77e663b832d5b0e544c5511e680c'] = 'Not supported';
$_MODULE['<{epayment}prestashop>payboxadminconfig_ebb061953c0454b2c8ee7b0ac615ebcd'] = 'Optional';
$_MODULE['<{epayment}prestashop>payboxadminconfig_e89ab59baea830bd940c300886c50efe'] = 'Mandatory';
$_MODULE['<{epayment}prestashop>payboxadminconfig_469ab723ab01f00c800a935ff51d3c8c'] = 'Add card';
$_MODULE['<{epayment}prestashop>payboxadminconfig_03b20e20e097cee014e5f889ac92cafc'] = 'The default identifiers below are those of a general test account. Once you have registered with Verifone e-commerce, your dedicated identifiers will be sent to you by email.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_a7d6475ec8993b7224d6facc8cb0ead6'] = 'Site number';
$_MODULE['<{epayment}prestashop>payboxadminconfig_fd33abdf2ff42b08cc100b90874b3a54'] = 'Site number (provided by Verifone e-commerce).';
$_MODULE['<{epayment}prestashop>payboxadminconfig_021da1b20f73dc252361a54d80497ef3'] = 'Rank number';
$_MODULE['<{epayment}prestashop>payboxadminconfig_27eab08f804ed489952126bb4cad62f1'] = 'Rank number (provided by Verifone e-commerce, last 2 digits).';
$_MODULE['<{epayment}prestashop>payboxadminconfig_29ee5d1ebcc033234938a5234f1f2075'] = 'Identifier';
$_MODULE['<{epayment}prestashop>payboxadminconfig_dcf3cb3a6763129c8a903e956346c53e'] = 'Verifone e-commerce identifier (provided by Verifone e-commerce).';
$_MODULE['<{epayment}prestashop>payboxadminconfig_9b808d1e9bccb91c8f45981e1e640e9b'] = 'HMAC key';
$_MODULE['<{epayment}prestashop>payboxadminconfig_4d2b8e0603c6c57d9e2576f29b37ce23'] = 'Secret HMAC key created using the Verifone e-commerce Back-Office.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_8521c28a20109b2781f8c94205396473'] = 'php-curl extension is not loaded';
$_MODULE['<{epayment}prestashop>payboxadminconfig_5fa5889342ac2a209d94d6b627bacd25'] = 'php-openssl extension is not loaded';
$_MODULE['<{epayment}prestashop>payboxadminconfig_d922d9791b4e76f261b9b0b7176776b3'] = 'Server configuration';
$_MODULE['<{epayment}prestashop>payboxadminconfig_6357d3551190ec7e79371a8570121d3a'] = 'There are';
$_MODULE['<{epayment}prestashop>payboxadminconfig_07213a0161f52846ab198be103b5ab43'] = 'errors';
$_MODULE['<{epayment}prestashop>payboxadminconfig_4ce81305b7edb043d0a7a5c75cab17d0'] = 'There is';
$_MODULE['<{epayment}prestashop>payboxadminconfig_cb5e100e5a9a3e7f6d1fd97512215282'] = 'error';
$_MODULE['<{epayment}prestashop>payboxadminconfig_4d6616c9df28f093418299eff95e6bc8'] = 'Please contact your server administrator';
$_MODULE['<{epayment}prestashop>payboxadminconfig_07e74c5936157cd46bcd91312141b890'] = '<strong>An update of this module is available:</strong><ul><li>Current version: %s</li><li>Latest version: %s</li></ul><br />Download the latest version <a href="%s" target="_blank">clicking here</a>';
$_MODULE['<{epayment}prestashop>payboxadminconfig_6a26f548831e6a8c26bfbbd9f6ec61e0'] = 'Documentation';
$_MODULE['<{epayment}prestashop>payboxadminconfig_5d385d9367041645ec4895b1d67ef129'] = 'Card information deleted';
$_MODULE['<{epayment}prestashop>payboxadminconfig_c33eb184f6c1a57824628e5123a30a1e'] = 'All field are required';
$_MODULE['<{epayment}prestashop>payboxadminconfig_8a77ca3bbba39861216637ba9ca01fcb'] = 'This card already Exists';
$_MODULE['<{epayment}prestashop>payboxadminconfig_aad781b9842958b4552b8edebb83c346'] = 'File operation failed';
$_MODULE['<{epayment}prestashop>payboxadminconfig_c0dec3a51ee700ac11eb6f2e03b20307'] = 'Please select a type of flow';
$_MODULE['<{epayment}prestashop>payboxadminconfig_41e23a86574da9dd6ae6b5f347c1c840'] = 'Error when creating this card.';
$_MODULE['<{epayment}prestashop>payboxadminconfig_cf6aa1b88fb657a5fc23e433a398292a'] = 'Card information added';
$_MODULE['<{epayment}prestashop>payboxadminconfig_928611f39892e71b416e2726aae56982'] = 'Verifone e-commerce module information updated';

$_MODULE['<{epayment}prestashop>payboxadminorder_ab116d52ec2aa15f6cc3c5ff66deb399'] = 'Payment details';
$_MODULE['<{epayment}prestashop>payboxadminorder_4c943e22dcb7953912d021539cc07de5'] = 'Verifone e-commerce reference:';
$_MODULE['<{epayment}prestashop>payboxadminorder_d36a6948b01d3a75ed99858e2bfea939'] = 'Payment Method:';
$_MODULE['<{epayment}prestashop>payboxadminorder_ad921d60486366258809553a3db49a4a'] = 'unknown';
$_MODULE['<{epayment}prestashop>payboxadminorder_844e7ee823419cc4a0986958bb430056'] = 'Card\'s country :';
$_MODULE['<{epayment}prestashop>payboxadminorder_ac0b636f024bcc73b2d71ed1bf1764e3'] = 'IP\'s country:';
$_MODULE['<{epayment}prestashop>payboxadminorder_93cba07454f06a4a960172bbd6e2a435'] = 'Yes';
$_MODULE['<{epayment}prestashop>payboxadminorder_bafd7322c6e97d25b6299b5d6fe8920b'] = 'No';
$_MODULE['<{epayment}prestashop>payboxadminorder_c58b4b2c3601f78fb2517fd7cc45652f'] = '3-D Secure Warranty :';
$_MODULE['<{epayment}prestashop>payboxadminorder_f9f8ae0c467bd8fb869eb8be45539c1a'] = 'Processing date:';
$_MODULE['<{epayment}prestashop>payboxadminorder_db1859a57cccebbc116f09cdda5d291e'] = 'The transaction can only be charged once';
$_MODULE['<{epayment}prestashop>payboxadminorder_cfc91014f99db0ee15596c180c30e026'] = 'Capture transaction\'s total';
$_MODULE['<{epayment}prestashop>payboxadminorder_adb8b1b45071f6a1a9f147bb3f461f9f'] = 'Capture of an amount';
$_MODULE['<{epayment}prestashop>payboxadminorder_4d9b94e5a37c33f49ac31e1994a1efd8'] = 'Capture this amount';
$_MODULE['<{epayment}prestashop>payboxadminorder_172c9a1ce835fa1c5c436c2ea8bdc3ea'] = 'Canceling a product will not capture the transaction.';
$_MODULE['<{epayment}prestashop>payboxadminorder_f94f77617fb8ec929d75d05aedb9d6fd'] = 'Cancel a product';
$_MODULE['<{epayment}prestashop>payboxadminorder_729a51874fe901b092899e9e8b31c97a'] = 'Are you sure?';
$_MODULE['<{epayment}prestashop>payboxadminorder_9c9db876a4778dede8de36f90ffe9c37'] = 'Please manage your Kwixo transaction in your Verifone e-commerce Back-Office';
$_MODULE['<{epayment}prestashop>payboxadminorder_f5f4d2b53842af29c05e97e4a45b02d4'] = 'Refund the first payment';
$_MODULE['<{epayment}prestashop>payboxadminorder_05e3d85f49a416771060fdefd4e04101'] = 'Cancel the next recurring payment';
$_MODULE['<{epayment}prestashop>payboxadminorder_225b46134ae90abfc7be431b67ca464b'] = 'The transaction can only be refunded once';
$_MODULE['<{epayment}prestashop>payboxadminorder_94524371d20123cfc4477fce11bab28a'] = 'It is possible to repay';
$_MODULE['<{epayment}prestashop>payboxadminorder_c2a5e2e23d8ec9cad779d657b7d33fc1'] = 'Refund total transaction';
$_MODULE['<{epayment}prestashop>payboxadminorder_e5f7bb30fde19b0a2941559b6089c06e'] = 'Refund an item';
$_MODULE['<{epayment}prestashop>payboxadminorder_90175177b7a2df85e0736fb05cc274c8'] = 'Refund of an amount';
$_MODULE['<{epayment}prestashop>payboxadminorder_ce625fef3fb76f45e7d15d10e2a51c23'] = 'Refund this amount';
$_MODULE['<{epayment}prestashop>payboxadminorder_a0d09826326fd385f6ceb17442f290de'] = 'Error when making capture request';
$_MODULE['<{epayment}prestashop>payboxadminorder_fc7262400f9e9a26f1f7955bdffab997'] = 'Funds have been captured.';
$_MODULE['<{epayment}prestashop>payboxadminorder_c9e096db0bf6301fc7df16ee3bffbfa4'] = 'Capture of funds unsuccessful. Please see log message!';
$_MODULE['<{epayment}prestashop>payboxadminorder_2f14e6767a310e5249e8de3c93369b76'] = 'Error when making capture';
$_MODULE['<{epayment}prestashop>payboxadminorder_a65b3500bd471c19695e5cba9a698dbb'] = 'The amount to capture is too high.';
$_MODULE['<{epayment}prestashop>payboxadminorder_9c84fa19ab673de2ce7d307ca6db8fd6'] = 'Error when canceling recurring payment.';
$_MODULE['<{epayment}prestashop>payboxadminorder_93c539e048882ac6567e82451c862b6f'] = 'Unable to cancel recurring payment.';
$_MODULE['<{epayment}prestashop>payboxadminorder_a663d6b06e01c66eb08df695001cbdea'] = 'For more information logon to the Verifone e-commerce Back-Office';
$_MODULE['<{epayment}prestashop>payboxadminorder_8bd7ba09b92a26ef2ceaef8d2fdc7947'] = 'Recurring payment canceled.';
$_MODULE['<{epayment}prestashop>payboxadminorder_e03187f3f9d6eda06a2a7c201f58cdca'] = 'Error when making refund request';
$_MODULE['<{epayment}prestashop>payboxadminorder_aeca7e93a1b3d77e38c3cffa131774d5'] = 'Refund has been made.';
$_MODULE['<{epayment}prestashop>payboxadminorder_cba030a50c8a99c7e224adbe1cf58544'] = 'Refund request unsuccessful. Please see log message!';
$_MODULE['<{epayment}prestashop>payboxadminorder_7562c6b13c0f06f957ea2accbf55a914'] = 'The refund amount is too high.';
$_MODULE['<{epayment}prestashop>payboxadminorder_44cdd2788ef82e668dd74f24d332d026'] = 'Generate a Verifone e-commerce refund';
$_MODULE['<{epayment}prestashop>payboxcontroller_a2774dd308f6939d7972a3d636648b5c'] = 'Payment was canceled by the customer on Verifone e-commerce payment page.';
$_MODULE['<{epayment}prestashop>payboxcontroller_3ffa86b923125b13ed710de4dfb45937'] = 'Payment canceled';
$_MODULE['<{epayment}prestashop>payboxcontroller_d87152f68d5707e82aeb2f870a23a0f1'] = 'Customer is back from Verifone e-commerce payment page.';
$_MODULE['<{epayment}prestashop>payboxcontroller_8919897c030fd7803c18b783b13031a8'] = 'Payment refused by Verifone e-commerce';
$_MODULE['<{epayment}prestashop>payboxcontroller_9aad419fa332fea21c46cb5a31739e1c'] = 'IPN call from %s not allowed.';
$_MODULE['<{epayment}prestashop>payboxcontroller_b7a9ba6c6ee36fd4714ca33e7f24a3a5'] = 'Missing %s parameter in Verifone e-commerce call';
$_MODULE['<{epayment}prestashop>payboxcontroller_118b785b4a51f6a9f465ae6c3fb14405'] = 'Unexpected type %s';
$_MODULE['<{epayment}prestashop>payboxcontroller_7d0914f9f39b28e016e738f1fc6667e0'] = 'Payment was refused by Verifone e-commerce (%s).';
$_MODULE['<{epayment}prestashop>payboxcontroller_e82a1ef1d0a2543d0d5bfe9ae5b479fa'] = 'No cart found';
$_MODULE['<{epayment}prestashop>payboxcontroller_4f03b2b8bc9a48d7c2c860a824fa0389'] = 'Order already validated';
$_MODULE['<{epayment}prestashop>payboxcontroller_0c1e036c5900f62ae69367e3edd34b11'] = 'This is a debug view. Click continue to be redirected to Verifone e-commerce payment page.';
$_MODULE['<{epayment}prestashop>payboxcontroller_d7cdf15f2cc3f1df15dd63a95b6fa93b'] = 'You will be redirected to the Verifone e-commerce payment page. If not, please use the button bellow.';
$_MODULE['<{epayment}prestashop>payboxcontroller_128ffabd063f7e93997e9cc724d4656a'] = 'Continue...';
$_MODULE['<{epayment}prestashop>payboxcontroller_c0ec9c8ca9673af558f12077d508f26d'] = 'Please wait while validating the order...';
$_MODULE['<{epayment}prestashop>payboxhelper_e5d5d9f40763cfe6549bef705e3529a7'] = 'Payment message is not valid, please check your module.';
$_MODULE['<{epayment}prestashop>payboxhelper_baa4595046869c3420b9ff1e93cf57db'] = 'Verifone e-commerce seems to be unreachable. Please try again later.';
$_MODULE['<{epayment}prestashop>payboxhelper_93c539e048882ac6567e82451c862b6f'] = 'Unable to cancel recurring payment.';
$_MODULE['<{epayment}prestashop>payboxhelper_642efa70c270e482639642acc184be0c'] = 'For more information logon to the Verifone e-commerce Back-Office.';
$_MODULE['<{epayment}prestashop>payboxhelper_8bd7ba09b92a26ef2ceaef8d2fdc7947'] = 'Recurring payment canceled.';
$_MODULE['<{epayment}prestashop>payboxhelper_18db8bcbfc56873f12dde8f4d21ec585'] = 'Capture operation:';
$_MODULE['<{epayment}prestashop>payboxhelper_6df924d545e77c408f8caf577db103eb'] = 'Return code: error';
$_MODULE['<{epayment}prestashop>payboxhelper_19e66d361a4d3ea5f4e105dee89def3e'] = 'Capture amount:';
$_MODULE['<{epayment}prestashop>payboxhelper_a663d6b06e01c66eb08df695001cbdea'] = 'For more information logon to the Verifone e-commerce Back-Office';
$_MODULE['<{epayment}prestashop>payboxhelper_bbba58ed8d1a08cff9c7e75ef6ef9c8e'] = 'Return code: ok';
$_MODULE['<{epayment}prestashop>payboxhelper_4c943e22dcb7953912d021539cc07de5'] = 'Verifone e-commerce Ref. :';
$_MODULE['<{epayment}prestashop>payboxhelper_8823c3322487fa165798e1a1fc119e5b'] = 'Verifone e-commerce capture amount:';
$_MODULE['<{epayment}prestashop>payboxhelper_eeaea52b80b3828c59ff7b79d96ff543'] = 'Verifone e-commerce total refund amount:';
$_MODULE['<{epayment}prestashop>payboxhelper_b6f98e01ee326d0b42f99bf1e404f82e'] = 'Verifone e-commerce partial refund amount:';
$_MODULE['<{epayment}prestashop>payboxhelper_f8dfbd565b5bde8dcc465980aff50385'] = 'Refund amount:';
$_MODULE['<{epayment}prestashop>payboxhelper_827e83dc250eafe83f34673a2c50bbe7'] = 'Verifone e-commerce refund:';
$_MODULE['<{epayment}prestashop>payment-rwd_c762cbab61dd438ce6b581790c8ecdf2'] = 'Payment canceled.';
$_MODULE['<{epayment}prestashop>payment-rwd_25c51b8b75b08180fc622fe31b9ff0ff'] = 'Payment refused by Verifone e-commerce.';
$_MODULE['<{epayment}prestashop>payment-rwd_c4ef2c6a7fca335f0aa415a16d0844a4'] = 'The Verifone e-commerce payment module is in test mode.';
$_MODULE['<{epayment}prestashop>payment-rwd_27266fe4d37bf06589c7c6dbf2d5c067'] = 'Pay by';
$_MODULE['<{epayment}prestashop>payment-rwd_99938b17c91170dfb0c2f3f8bc9f2a85'] = 'Pay';
$_MODULE['<{epayment}prestashop>payment-rwd_7ca7269f2c36cb468f1a5ad42d9585a0'] = 'card in 3 times without fees';
$_MODULE['<{epayment}prestashop>payment_c762cbab61dd438ce6b581790c8ecdf2'] = 'Payment canceled.';
$_MODULE['<{epayment}prestashop>payment_25c51b8b75b08180fc622fe31b9ff0ff'] = 'Payment refused by Verifone e-commerce.';
$_MODULE['<{epayment}prestashop>payment_c4ef2c6a7fca335f0aa415a16d0844a4'] = 'The Verifone e-commerce payment module is in test mode.';
$_MODULE['<{epayment}prestashop>payment_27266fe4d37bf06589c7c6dbf2d5c067'] = 'Pay by';
$_MODULE['<{epayment}prestashop>payment_0ee8708cdd961e50236ac98a73a540a9'] = 'card 3 times without fees';
