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
    <th><?php $mf->e_('postcode', 0); ?></th>
    <td><input type="text" <?php $mf->e_('postcode'); ?> placeholder="例）000-0000" value="<?php $mf->eh_esc(@$_SESSION[$slug]['postcode'][1]); ?>" /></td>
</tr>
<tr>
    <th><?php $mf->e_('address', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('address'); ?> value="<?php $mf->eh_esc(@$_SESSION[$slug]['address'][1]); ?>" />
    </td>
</tr>
<tr>
    <th><?php $mf->e_('tel_num', 0); ?><em>必須</em></th>
    <td>
        <input type="text" <?php $mf->e_('tel_num'); ?> placeholder="例）0000-00-0000" value="<?php $mf->eh_esc(@$_SESSION[$slug]['tel_num'][1]); ?>" />
    </td>
</tr>
<tr>
    <th><?php $mf->e_('first_date_time', 0); ?><em>必須</em></th>
    <td>
    	<select <?php $mf->e_('select_first_y'); ?>>
            <?php $year = date('Y'); 
            $mf->selectBox($year, $year+2, $mf->h_esc(@$_SESSION[$slug]['select_first_y'][1])); ?>
        </select>
        <span>年</span>
        
        <select <?php $mf->e_('select_first_m'); ?>>
            <?php $mf->selectBox(1, 12, $mf->h_esc(@$_SESSION[$slug]['select_first_m'][1])); ?>
        </select>
        <span>月</span>
        
        <select <?php $mf->e_('select_first_d'); ?>>
            <?php $mf->selectBox(1, 31, $mf->h_esc(@$_SESSION[$slug]['select_first_d'][1])); ?>
        </select>
        <span>日</span>
        
        <select <?php $mf->e_('select_first_t'); ?>>
            <?php $mf->selectBox(8, 22, $mf->h_esc(@$_SESSION[$slug]['select_first_t'][1])); ?>
        </select>
        <span>時</span>
    </td>
</tr>
<tr>
    <th><?php $mf->e_('trade_name', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('trade_name'); ?> value="<?php $mf->eh_esc(@$_SESSION[$slug]['trade_name'][1]); ?>" />
    </td>
</tr>
<tr>
    <th><?php $mf->e_('work_type', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('work_type'); ?> placeholder="" value="<?php $mf->eh_esc(@$_SESSION[$slug]['work_type'][1]); ?>">
    </td>
</tr>
<tr>
    <th><?php $mf->e_('history', 0); ?></th>
    <td>
        <textarea rows="3" cols="8" <?php $mf->e_('history'); ?>><?php $mf->eh_esc(@$_SESSION[$slug]['history'][1]); ?></textarea>
    </td>
</tr>
<tr>
    <th><?php $mf->e_('experience', 0); ?></th>
    <td>
        <input type="radio" <?php $mf->e_('experience'); ?> value="なし"<?php $mf->checkRadioSession('なし', 'experience', 1); ?>><span>なし</span>
        <input type="radio" <?php $mf->e_('experience'); ?> value="あり"<?php $mf->checkRadioSession('あり', 'experience'); ?>><span>あり</span>
    </td>
</tr>
<tr>
    <th><?php $mf->e_('concept', 0); ?></th>
    <td>
        <textarea rows="3" cols="8" <?php $mf->e_('concept'); ?>><?php $mf->eh_esc(@$_SESSION[$slug]['purpose'][1]); ?></textarea>
    </td>
</tr>

<tr>
    <th><?php $mf->e_('main_service', 0); ?></th>
    <td>
        <textarea rows="3" cols="8" <?php $mf->e_('main_service'); ?>><?php $mf->eh_esc(@$_SESSION[$slug]['main_service'][1]); ?></textarea>
    </td>
</tr>
<tr>
    <th><?php $mf->e_('sales_point', 0); ?></th>
    <td>
        <textarea rows="3" cols="8" <?php $mf->e_('sales_point'); ?>><?php $mf->eh_esc(@$_SESSION[$slug]['sales_point'][1]); ?></textarea>
    </td>
</tr>
<tr>
    <th><?php $mf->e_('hope_size', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('hope_size'); ?> placeholder="" value="<?php $mf->eh_esc(@$_SESSION[$slug]['hope_size'][1]); ?>">
        <span>m<sup>2</sup></span>
    </td>
</tr>
<tr>
    <th><?php $mf->e_('worker_num', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('worker_num'); ?> placeholder="" value="<?php $mf->eh_esc(@$_SESSION[$slug]['worker_num'][1]); ?>">
        <span>人</span>
    </td>
</tr>
<tr>
    <th><?php $mf->e_('comment', 0); ?></th>
    <td>
        <textarea rows="3" cols="8" <?php $mf->e_('comment'); ?>><?php $mf->eh_esc(@$_SESSION[$slug]['comment'][1]); ?></textarea>
    </td>
</tr>
  
    
    
