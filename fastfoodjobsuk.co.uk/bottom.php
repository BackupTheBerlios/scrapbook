						<!--div cancelled-->	<!--</div>--><!--content ends-->
						</td>
						<?php if ($wide){ ?>
							<td valign="top" width="167">
							</td>
						<?php } elseif($wpv) {?>
								<td style ="width:1px; background-color:#ccc;"></td><td valign="top" width="150"><table cellpadding="0" cellspacing="0"><tr><td valign = "top">
								<?php if ($member->image1!=="") { ?>
								<img src="logos/<?php echo $member->image1; ?>" width="<?php echo $platinumImageWidth; ?>" height="<?php echo $platinumImageHeight; ?>" class="topimageright">
								<?php } else { ?>
								<img src="images/spacer.gif" width="<?php echo $platinumImageWidth; ?>" height="<?php echo $platinumImageHeight; ?>" class="topimageleft">
								<?php } ?>
								<br>
								<?php if ($member->image2!=="") { ?>
								<img src="logos/<?php echo $member->image2; ?>" width="<?php echo $platinumImageWidth; ?>" height="<?php echo $platinumImageHeight; ?>" class="topimageright">
								<?php } else { ?>
								<img src="images/spacer.gif" width="<?php echo $platinumImageWidth; ?>" height="<?php echo $platinumImageHeight; ?>" class="topimageleft">
								<?php } ?>		</td></tr><br />
								<tr><td><div  id="details">
								<div>
								<a class = "news" href="<?php echo $member->link; ?>">
								<?php echo $member->name; ?>
								</a> 
								</div>
								<div id = "addresstext">
								<?php echo str_replace("\n","<br>",$member->address); ?>
								</div>
								<div>
								Tel: 
								<?php echo $member->tel; ?>
								</div>
								<div>
								Fax: 
								<?php echo $member->fax; ?>
								</div>
								<div>
								Email: 
								<a class = "news" href = mailto:"<?php echo $member->email; ?>">Click here</a> to email.
								</div>
								<div>
								Web:        <a class = "news" href="<?php echo $member->link; ?>">
								Click Here
								</a> for website.
								</div></div>
								</td></tr></table>
								</td>
						<?php } else { ?>
							<td valign="top" width="167">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
									  <td height="116" align="right"><?php loadImage();?></td>
									</tr>
									<tr>
									  <td height="116" align="right"><?php loadImage();?></td>
									</tr>
									<tr>
									  <td height="116" align="right"><?php loadImage();?></td>
									</tr>
									<tr>
										<td width="167" align="right"><a href="http://www.jestic.co.uk/" target="_blank"><img src="images/wingright_19.gif" alt="" width="162" height="192" border="0" align="right" /></a></td>
									</tr>
								</table>		
							</td>								
						<?php } ?>
                      </tr>
                    </table>
                    </td>
<td background="images/page_09.gif"><img src="images/page_09.gif" alt="" width="11" height="685" border="0" /></td>
              </tr>
              <tr>
                <td><img src="images/page_58.gif" alt="" width="11" height="12" border="0" /></td>
                <td width="797"><img src="images/page_59.gif" alt="" width="797" height="12" border="0" /></td>
                <td><img src="images/page_56.gif" alt="" width="9" height="12" border="0" /></td>
              </tr>
            </table>
			<table width="807" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="182"><a class="bottomNav" href="javascript:void(window.open('terms.html'));">Term &amp; Conditions</a> | <a class="bottomNav" href="javascript:void(window.open('privacy.html'));">Privacy Policy</a></td>
               <td width="3"></td>
               <td width="622" align="right"><p class="copyright">Copyright &copy; 2007 TTP Enterprises Ltd trading as Fast Food Jobs UK. All rights reserved. Designed by <a href="http://www.highlevelmedia.co.uk" target="_blank">www.highlevelmedia.co.uk</a></p></td>
    </tr>
            </table>
			<br>
	</div>
	</body>
</html>