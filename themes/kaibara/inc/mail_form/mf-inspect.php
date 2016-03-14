<?php
/* */
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
    <th><?php $mf->e_('belong', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('belong'); ?> value="<?php $mf->eh_esc(@$_SESSION[$slug]['belong'][1]); ?>" />
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
        <select <?php $mf->e_('select_first_m'); ?>>
            <?php $mf->selectBox(1, 12, $mf->h_esc(@$_SESSION[$slug]['select_first_m'][1])); ?>
        </select>
        <span>月</span>
        
        <select <?php $mf->e_('select_first_d'); ?>>
            <?php $mf->selectBox(1, 31, $mf->h_esc(@$_SESSION[$slug]['select_first_d'][1])); ?>
        </select>
        <span>日　</span>
        
        <select <?php $mf->e_('select_first_t'); ?>>
            <?php $mf->selectBox(8, 22, $mf->h_esc(@$_SESSION[$slug]['select_first_t'][1])); ?>
        </select>
        <span>時</span>
    </td>
</tr>

<tr>
    <th><?php $mf->e_('second_date_time', 0); ?><em>必須</em></th>
    <td>        
        <select <?php $mf->e_('select_second_m'); ?>>
            <?php $mf->selectBox(1, 12, $mf->h_esc(@$_SESSION[$slug]['select_second_m'][1])); ?>
        </select>
        <span>月</span>
        <select <?php $mf->e_('select_second_d'); ?>>
            <?php $mf->selectBox(1, 31, $mf->h_esc(@$_SESSION[$slug]['select_second_d'][1])); ?>
        </select>
        <span>日　</span>
        <select <?php $mf->e_('select_second_t'); ?>>
            <?php $mf->selectBox(8, 22, $mf->h_esc(@$_SESSION[$slug]['select_second_t'][1])); ?>
        </select>
        <span>時</span>
    </td>
</tr>

<tr>
    <th><?php $mf->e_('people_num', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('people_num'); ?> placeholder="" value="<?php $mf->eh_esc(@$_SESSION[$slug]['people_num'][1]); ?>">
        <span>人</span>
    </td>
</tr>

<tr>
    <th><?php $mf->e_('park_num', 0); ?></th>
    <td>
        <input type="text" <?php $mf->e_('park_num'); ?> placeholder="" value="<?php $mf->eh_esc(@$_SESSION[$slug]['park_num'][1]); ?>">
        <span>台</span>
    </td>
</tr>

<tr>
    <th><?php $mf->e_('bus', 0); ?></th>
    <td>
        <input type="radio" <?php $mf->e_('bus'); ?> value="なし"<?php $mf->checkRadioSession('なし', 'bus', 1); ?>><span>なし</span>
        <input type="radio" <?php $mf->e_('bus'); ?> value="あり"<?php $mf->checkRadioSession('あり', 'bus'); ?>><span>あり</span>
    </td>
</tr>

<tr>
    <th><?php $mf->e_('lunch', 0); ?></th>
    <td>
        <input type="radio" <?php $mf->e_('lunch'); ?> value="なし"<?php $mf->checkRadioSession('なし','lunch', true); ?>><span>なし</span>
        <input type="radio" <?php $mf->e_('lunch'); ?> value="あり"<?php $mf->checkRadioSession('あり', 'lunch'); ?>><span>あり</span>
    
    </td>
</tr>

<tr>
    <th><?php $mf->e_('purpose', 0); ?><em>必須</em><small>※特にウェイトを置く分野などをご記入下さい。</small></th>
    <td>
    	<?php if(isAgent('MSIE 9.0')) echo "例）まちづくり柏原について、たんば黎明館について"; ?>
        <textarea rows="3" cols="8" <?php $mf->e_('purpose'); ?> placeholder="例）まちづくり柏原について、たんば黎明館について"><?php $mf->eh_esc(@$_SESSION[$slug]['purpose'][1]); ?></textarea>
    </td>
</tr>

<tr>
    <th><?php $mf->e_('comment', 0); ?></th>
    <td>
        <textarea rows="3" cols="8" <?php $mf->e_('comment'); ?>><?php $mf->eh_esc(@$_SESSION[$slug]['comment'][1]); ?></textarea>
    </td>
</tr>
    
