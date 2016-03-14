<?php 
/*  */
?>

<tr>    
    <th><?php $mf->e_('nick_name', 0); ?><em>必須</em></th>
    <td>
        <input type="text" <?php $mf->e_('nick_name'); ?> placeholder="" value="<?php $mf->eh_esc(@$_SESSION[$slug]['nick_name'][1]); ?>" />
    </td>
</tr>
<tr>
    <th><?php $mf->e_('mail_add', 0); ?><em>必須</em></th>
    <td>
        <input type="email" <?php $mf->e_('mail_add'); ?> placeholder="" value="<?php $mf->eh_esc(@$_SESSION[$slug]['mail_add'][1]); ?>" />
    </td>
</tr>
<tr>
    <th><?php $mf->e_('comment', 0); ?></th>
    <td>
        <textarea rows="3" cols="8" <?php $mf->e_('comment'); ?>><?php $mf->eh_esc(@$_SESSION[$slug]['comment'][1]); ?></textarea>
    </td>
</tr>
  
    
    
