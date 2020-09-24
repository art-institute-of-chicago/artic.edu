import React, { Component } from 'react';
import ButtonGroup from '@material-ui/core/ButtonGroup';
import { withStyles } from '@material-ui/core/styles';
import Button from '@material-ui/core/Button';
import SvgIcon from '@material-ui/core/SvgIcon';
import { getViewer } from 'mirador/dist/es/src/state/selectors';

//custom icons
const ZoomInIcon = (props) => (
  <SvgIcon {...props}>
    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
      <circle cx='10.5' cy='10.5' r='5.5' fill='none' stroke='currentColor' stroke-linejoin='bevel' stroke-width='1.4'/>
      <line x1='14.5' y1='14.5' x2='19' y2='19' fill='none' stroke='currentColor' stroke-linecap='square' stroke-linejoin='bevel' stroke-width='1.4'/>
      <rect x='10' y='8' width='1' height='5' fill='currentColor'/>
      <rect x='10' y='8' width='1' height='5' transform='translate(21) rotate(90)' fill='currentColor'/>
    </svg>
  </SvgIcon>
);

const ZoomOutIcon = (props) => (
  <SvgIcon {...props}>
    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
        <circle cx='10.5' cy='10.5' r='5.5' fill='none' stroke='currentColor' stroke-linejoin='bevel' stroke-width='1.4'/>
        <line x1='14.5' y1='14.5' x2='19' y2='19' fill='none' stroke='currentColor' stroke-linecap='square' stroke-linejoin='bevel' stroke-width='1.4'/>
      <rect x='10' y='8' width='1' height='5' transform='translate(21) rotate(90)' fill='currentColor'/>
  </svg>
  </SvgIcon>
);

const CustomButton = withStyles({
  root: {
    backgroundColor: 'rgba(0,0,0,.5)',
    border: 0,
    borderRadius: 0,
    color: '#ffffff',
    height: 48,
    width: 48,
    marginLeft: '1px',
    '&:hover': {
      backgroundColor: 'rgba(0,0,0,.6)',
    },
  },
})(Button);

class ZoomButtonsPlugin extends Component {
  /**
   * constructor -
   */
  constructor(props) {
    super(props);

    this.handleZoomInClick = this.handleZoomInClick.bind(this);
    this.handleZoomOutClick = this.handleZoomOutClick.bind(this);
  }

  /**
   * @private
   */
  handleZoomInClick() {
    const { windowId, updateViewport, windowViewProperties } = this.props;

    updateViewport(windowId, {
      zoom: windowViewProperties.zoom * 2,
    });
  }

  /**
   * @private
   */
  handleZoomOutClick() {
    const { windowId, updateViewport, windowViewProperties } = this.props;

    updateViewport(windowId, {
      zoom: windowViewProperties.zoom / 2,
    });
  }

  // add aria labels to buttons
  render() {
    return (
      <div style={{position: 'absolute', bottom: 32, right: 32, left:'auto', zIndex:500}}>
        <ButtonGroup size='large' disableElevation variant='contained' color='primary' >
          <CustomButton aria-label='zoom in' onClick={this.handleZoomInClick}>
            <ZoomInIcon />
          </CustomButton>
          <CustomButton aria-label='zoom out' onClick={this.handleZoomOutClick}>
            <ZoomOutIcon />
          </CustomButton>
        </ButtonGroup>
      </div>
    );
  }
}

/**
 * mapStateToProps - to hook up connect
 * @memberof Workspace
 * @private
 */
const mapStateToProps = (state, { windowId }) => (
  {
    windowViewProperties: getViewer(state, { windowId }),
  }
);

export default {
  component: ZoomButtonsPlugin,
  mapStateToProps: mapStateToProps,
  target: 'OpenSeadragonViewer',
  mode: 'add',
};

