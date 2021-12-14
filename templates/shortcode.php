<?php if(!empty($subcategories)) : ?>
    <div class="solberg_categories_filter">
        <form action="" method="get">
            <select name="solberg_order" id="solberg_order">
                <option value="ASC" <?php echo $solberg_order == 'ASC' ? 'selected' : ''; ?>><?php echo esc_attr__('Order: From low to high', 'solberg_plugin'); ?></option>
                <option value="DESC" <?php echo $solberg_order == 'DESC' ? 'selected' : ''; ?>><?php echo esc_attr__('Order: From high to low', 'solberg_plugin'); ?></option>
            </select>
            <input type="submit" value="<?php echo esc_attr__('Filter', 'solberg_plugin'); ?>" />
        </form>
    </div>
    <div class="solberg_categories">
        <?php foreach ($subcategories as $subcategory) : $solberg_taxonomy_image = Solberg_Taxonomy::get_solberg_taxonomy_image($subcategory->term_id, 'Solberg Taxonomy'); ?>
            <div class="solberg_categories-row">
                <div class="solberg_categories-row-image">
                    <?php if($solberg_taxonomy_image !== false) : ?>
                        <img src="<?php echo esc_url($solberg_taxonomy_image['url']); ?>" alt=""/>
                    <?php endif; ?>
                </div>
                <div class="solberg_categories-row-title">
                    <?php echo esc_attr__($subcategory->name); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>