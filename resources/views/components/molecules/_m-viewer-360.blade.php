<div class="m-viewer-360" data-cc="{{ (isset($cc) && $cc != '') ? $cc : 'false' }}" data-type="{{ (isset($type)) ? $type : 'modal' }}" data-behavior="viewer360" data-title="{{ (isset($title)) ? $title : '' }}">

	<img class="m-viewer-360-image" src="" alt="" />
	
	<div class="m-viewer-360-control">
		<input
			aria-label="Seek"
			class="input360"
			{{--ref={this.inputRef}--}}
			type="range"
			min="0"
			max=""
			value=""
			name="frame"
			{{--onChange={this.handleInputChange}--}}
		/>
	</div>

</div>
