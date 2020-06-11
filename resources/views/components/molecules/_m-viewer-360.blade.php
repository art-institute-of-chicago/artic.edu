<div class="m-viewer-360 loader" data-cc="{{ (isset($cc) && $cc != '') ? $cc : 'false' }}" data-type="{{ (isset($type)) ? $type : 'modal' }}" data-behavior="viewer360" data-title="{{ (isset($title)) ? $title : '' }}" data-id="{{ (isset($id)) ? $id : 'assetLibrary' }}">
	<img style="{{ (isset($style)) ? $style : '' }}" draggable="false" class="m-viewer-360-image" src="" alt="{{ (isset($title)) ? $title : '' }}" />
	
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
