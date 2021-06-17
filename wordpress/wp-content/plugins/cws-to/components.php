<?php
function cws_core_merge_components($g, $l) {
	return array_merge($g, $l);
}

/*
	build resulting array with replaced %name% layouts with their real components
	nothing to return as we work with a reference
*/
function cws_core_build_settings (&$layout, $components) {
	foreach ($layout as $key => &$v) {
		if (isset($v['layout'])) {
			$llayout = $v['layout'];
			if (is_string($llayout) && '%' === substr($llayout, 0, 1)) {
				$name = substr($llayout, 1, -1);
				if (isset($components[$name])) {
					$v['layout'] = $components[$name]; // replace keyword with actual array
				}
			} else {
				cws_core_build_settings ($v['layout'], $components);
			}
		}
	}
}

function cws_core_get_base_components() {
	return array();
}
?>
