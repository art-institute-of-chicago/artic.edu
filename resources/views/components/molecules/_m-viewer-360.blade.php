<div class="m-viewer-360" data-cc="{{ (isset($cc) && $cc != '') ? $cc : 'false' }}" data-type="{{ (isset($type)) ? $type : 'modal' }}" data-behavior="viewer360" data-title="{{ (isset($title)) ? $title : '' }}">
	<img style="{{ (isset($style)) ? $style : '' }}" draggable="false" class="m-viewer-360-image loader" src= alt={{ (isset($title)) ? $title : '' }} />
	
	<div class="m-viewer-360-control">
		<input
			aria-label="Seek"
			class="input360"
			type="range"
			min="0"
			max=""
			value=""
			name="frame"
		/>
	</div>

</div>
