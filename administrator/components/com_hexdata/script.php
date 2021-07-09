<?php
/*------------------------------------------------------------------------
# com_hexdata - HexData
# ------------------------------------------------------------------------
# author    Team WDMtech
# copyright Copyright (C) 2014 www.wdmtech.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.wdmtech.com
# Technical Support:  Forum - http://www.wdmtech.com/support-forum
-----------------------------------------------------------------------*/
// No direct access
defined('_JEXEC') or die('Restricted access');
 
/**
 * Script file of HexData component
 */
class com_hexdataInstallerScript
{
	var $messages;
	var $status;
	var	$sourcePath;

	function execute()
	{

		//get version number from manifest file.
		$jinstaller	= JInstaller::getInstance();
		$installer = new HexdataInstaller( $jinstaller );
		$installer->execute();

		$this->messages	= $installer->getMessages();
	}
	
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) 
	{
		
		
		
	}
 
	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) 
	{
		
		
		
	}
 
	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) 
	{
		
	}
 
	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) 
	{
		
	}
 
	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) 
	{
		
		$messages = (array)$this->messages;
		
		?>

	<style type="text/css">
	.adminform tr th{
		display:none;
	}

	/* TYPOGRAPHY AND SPACING */
	#hexdata-installer td{
		font-size:11px;
		line-height:1.7;
		font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
	}
	#hexdata-installer td table td{
		padding:5px 2px 5px 10px;
	}

	/* MESSAGES */
	#hexdata-message {
		border:1px solid #ccc;
		padding:13px;
		border-radius:2px;
		-moz-border-radius:2px;
		-webkit-border-radius:2px;
		font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
	}

	#hexdata-message.error {
		border-color:#900;
		color: #900;
		font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
	}

	#hexdata-message.info {
		background:#ECEFF6;
		border-color:#c4cbdd;
		color:#555;
		font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
	}

	#hexdata-message.warning {
		border-color:#f90;
		color: #c30;
		font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
	}
	#stylized {
    background: none repeat scroll 0 0 #EBF4FB;
    border: 1px solid #B7DDF2;
	font-family: "lucida grande",tahoma,verdana,arial,sans-serif;
	}
	.myform {
		height: auto;
		margin: 0 auto;
		padding: 14px;
		width: auto;
	}
	</style>
	<div id="stylized" class="myform">
	<table id="hexdata-installer" width="100%" border="0" cellpadding="0" cellspacing="0">
		<?php
			foreach ($messages as $message) {
				?>
				<tr>
					<td><div id="hexdata-message" class="<?php echo $message['type']; ?>"><?php echo ucfirst($message['type']) . ' : ' . $message['message']; ?></div></td>
				</tr>
				<?php
			}
		?>
		<tr>
			<td>
				<div style="padding:20px 0"><img src="media/com_hexdata/images/icon-48-hexdata.png" /></div>
			</td>
		</tr>
		<tr>
			<td>
				<div style="width:700px; padding-left:10px">
					HexData is the most innovative Data Manipulation Joomla Extension.
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<table>
					<tr>
						<td colspan="2">To get our latest news and promotions :</td>
					</tr>
					<tr>
						<td>Like us on Facebook :</td>
						<td>
							<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-like" data-href="https://www.facebook.com/wdmtechnologies" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
						</td>
					<tr>
						<td>Follow us on Twitter :</td>
						<td>
							<a href="https://twitter.com/wdmtechnologies" class="twitter-follow-button" data-show-count="false">Follow @wdmtechnologies</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
						</td>
					</tr>
					<tr>
						<td colspan="2">If you use HexData, please post a rating and a review at <a href="http://extensions.joomla.org/extensions/migration-a-conversion/data-import-a-export/24713" target="_blank">Joomla! Extension Directory</a>.</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
    </div>
	
	<?php
		
	}
}
