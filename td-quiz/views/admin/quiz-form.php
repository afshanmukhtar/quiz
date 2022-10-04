<table cellspacing="2" cellpadding="5" style="width: 100%;" class="form-table">
    <tbody>
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="question"><?php _e('Question', 'tdq')?></label>
        </th>
        <td>
            <input id="question" name="question" type="text" style="width: 95%" value="<?php echo esc_attr($item['question'])?>"
                   size="50" class="code" placeholder="<?php _e('Question', 'tdq')?>" required>
        </td>
    </tr> 
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="category"><?php _e('Category', 'tdq')?></label>
        </th>
        
        <td>
             <select name="category" id="category">
                <?php foreach($categories as $cat): ?>
                <option value="<?php echo $cat; ?>" <? if($cat == $item['category']) echo 'selected'; ?>><?php echo $cat; ?></option>
                <?php endforeach; ?>
             </select>
             
        </td>
    </tr> 
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="quiz_group"><?php _e('Category', 'tdq')?></label>
        </th>
        
        <td>
             <select name="quiz_group" id="quiz_group">
                <?php foreach($groups as $gr): ?>
                <option value="<?php echo $gr; ?>" <? if($gr == $item['quiz_group']) echo 'selected'; ?>><?php echo $gr; ?></option>
                <?php endforeach; ?>
             </select>
             
        </td>
    </tr> 
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="page"><?php _e('Page', 'tdq')?></label>
        </th>
        
        <td>
             <select name="page" id="page">
                <?php foreach($pages as $page): ?>
                <option value="<?php echo $page; ?>" <? if($page == $item['page']) echo 'selected'; ?>><?php echo $page; ?></option>
                <?php endforeach; ?>
             </select>
             
        </td>
    </tr> 
     
    </tbody>
</table>