{*
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
*  @version   2.0.0
*  @author    BM Services <contact@bm-services.com>
*  @copyright 2012-2017 Verifone e-commerce
*  @license   http://opensource.org/licenses/OSL-3.0
*  @link      http://www.paybox.com/
*}

{if $payboxReason == 'cancel'}
<div class="paybox_error" style="margin-left:15px;">
	{l s='Payment canceled.' mod='epayment'}
</div>
{/if}

{if $payboxReason == 'error'}
<div class="paybox_error" style="margin-left:15px;">
	{l s='Payment refused by PaymentPlatform.' mod='epayment'}
</div>
{/if}

{if !$payboxProduction}
<div class="paybox_error" style="margin-left:15px;">
	{l s='The PaymentPlatform payment is in test mode.' mod='epayment'}
</div>

{/if}
{* Standard payment *}
{foreach from=$payboxCards item=card name=cards}
<p class="payment_module paybox_module">
	<a href="{$card.url|escape:'html'}">
		<img src="{$card.image}" alt="{$card.card}" title="{$card.card}" />
		{l s='Pay by' mod='epayment'} {$card.label}
	</a>
</p>
{/foreach}

{* Recurring payment *}
{if !empty($payboxRecurring)}
<p class="payment_module paybox_module">
	<img src="{$payboxImagePath}Paiement_3X.png" />
	{foreach from=$payboxRecurring item=card name=cards}
		<a href="{$card.url|escape:'html'}&amp;recurring=1">
			<img src="{$card.image}" alt="{$card.card}" title="{$card.card}" />
		</a>
	{/foreach}
	{l s='Pay by' mod='epayment'} {l s='card 3 times without fees' mod='epayment'}
</p>
{/if}
