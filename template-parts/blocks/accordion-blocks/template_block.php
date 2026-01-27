<?php

/**
 * Template Block
 * Location: template-parts/blocks/accordion-blocks/template_block.php
 */

$block_id = 'tmpl-' . uniqid(); // unique per block instance

$section_title = get_field('section_title') ?: 'Template Library';
$section_description = get_field('section_description') ?: '';
$cats_lvl1     = get_field('tmpl_cat_1') ?: [];

// Helper function: safely get URL from ACF file/image
function tmpl_safe_url($acf_field)
{
    if (!$acf_field) return '';
    if (is_array($acf_field) && !empty($acf_field['url'])) return esc_url($acf_field['url']);
    if (is_string($acf_field)) return esc_url($acf_field);
    return '';
}

// Build Level 4 (PDFs)
function tmpl_build_lvl4($rows)
{
    $out = [];
    if (empty($rows)) return $out;

    foreach ($rows as $row) {
        $title = $row['title_4'] ?? '';
        $img   = !empty($row['image_4']) ? tmpl_safe_url($row['image_4']) : '';
        $file  = $row['pdf_file'] ?? null;
        $url   = $file ? tmpl_safe_url($file) : '';

        // Handles "No PDF" toggle or empty link
        $no_pdf = !empty($row['no_pdf_note']) || empty($url);

        // Start the item with just a title
        $item = ['title' => $title];

        // Add optional image if available
        if ($img) {
            $item['image'] = $img;
        }

        // Add PDF URL only if it exists
        if (!$no_pdf && $url) {
            $item['url'] = $url;
            $item['type'] = 'pdf';
        } else {
            $item['type'] = 'placeholder';
        }

        $out[] = $item;
    }

    return $out;
}


// Build Level 3
function tmpl_build_lvl3($rows)
{
    $out = [];
    if (empty($rows)) return $out;
    foreach ($rows as $row) {
        $title = $row['title_3'] ?? '';
        $img   = tmpl_safe_url($row['image_3'] ?? '');
        $lvl4  = tmpl_build_lvl4($row['tmpl_cat_4'] ?? []);
        
        $item = [
            'title' => $title,
            'image' => $img
        ];
        
        // If there are children (level 4), use them
        if (!empty($lvl4)) {
            $item['children'] = $lvl4;
        } else {
            // No children, check if there's a PDF at this level
            $file = $row['pdf_file'] ?? null;
            $url  = $file ? tmpl_safe_url($file) : '';
            $no_pdf = !empty($row['no_pdf_note']) || empty($url);
            
            if (!$no_pdf && $url) {
                $item['url'] = $url;
                $item['type'] = 'pdf';
            } else {
                $item['type'] = 'placeholder';
            }
        }
        
        $out[] = $item;
    }
    return $out;
}

// Build Level 2
function tmpl_build_lvl2($rows)
{
    $out = [];
    if (empty($rows)) return $out;
    foreach ($rows as $row) {
        $title = $row['title_2'] ?? '';
        $img   = tmpl_safe_url($row['image_2'] ?? '');
        $lvl3  = tmpl_build_lvl3($row['tmpl_cat_3'] ?? []);
        
        $item = [
            'title' => $title,
            'image' => $img
        ];
        
        // If there are children (level 3), use them
        if (!empty($lvl3)) {
            $item['children'] = $lvl3;
        } else {
            // No children, check if there's a PDF at this level
            $file = $row['pdf_file'] ?? null;
            $url  = $file ? tmpl_safe_url($file) : '';
            $no_pdf = !empty($row['no_pdf_note']) || empty($url);
            
            if (!$no_pdf && $url) {
                $item['url'] = $url;
                $item['type'] = 'pdf';
            } else {
                $item['type'] = 'placeholder';
            }
        }
        
        $out[] = $item;
    }
    return $out;
}

// Build Level 1
$tabs = [];
$grids = [];

foreach ($cats_lvl1 as $row1) {
    $title_1 = $row1['title_1'] ?? '';
    if (!$title_1) continue;

    $key = sanitize_title($title_1);
    $tabs[] = [
        'key'   => $key,
        'label' => $title_1
    ];

    $lvl2 = tmpl_build_lvl2($row1['tmpl_cat_2'] ?? []);
    $grids[$key] = [
        'label' => $title_1,
        'items' => $lvl2
    ];
}

// Data for JS
$data = [
    'id'    => $block_id,
    'title' => $section_title,
    'tabs'  => $tabs,
    'grids' => $grids
];

// Attach data to window.TemplateTiles
// Script is enqueued in enqueue.php when on page-slug-templates-and-graphic-design
$inline = 'window.TemplateTiles = window.TemplateTiles || {};'
    . 'window.TemplateTiles[' . json_encode($block_id) . '] = ' . wp_json_encode($data) . ';';
wp_add_inline_script('custom-template-tiles', $inline, 'before');
?>

<section id="<?php echo esc_attr($block_id); ?>" class="template-block pb-75" aria-labelledby="<?php echo esc_attr($block_id); ?>-title">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <header class="template-header text-center pb-3">
                    <h2 class="text-secondary pt-4" id="<?php echo esc_attr($block_id); ?>-title"><?php echo $section_title; ?></h2>
                    <p><?php echo $section_description; ?></p>
                </header>

                <nav class="template-tabs py-4" aria-label="Template categories"></nav>
                <nav class="template-breadcrumb" aria-label="breadcrumb"></nav>
                <h3 class="template-level-title text-center text-primary" aria-live="polite"></h3>
                <div class="template-grids-container text-center" id="template-grids-container" data-block-id="<?php echo esc_attr($block_id); ?>"></div>

            </div>
        </div>
    </div>


</section>