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

const styles = theme => ({
  CustomZoomButton: {
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
    '&:disabled': {
      color: 'rgba(255,255,255,.2)',
      backgroundColor: 'rgba(0,0,0,.5)',
    },
    '&:not(:last-child)': {
      border: 0,
    }
  }
})

class ZoomButtonsPlugin extends Component {
  /**
   * constructor -
   */
  constructor(props) {
    super(props);

    this.state = {
      viewerFullyLoaded: false,
    }

    this.handleZoomInClick = this.handleZoomInClick.bind(this);
    this.handleZoomOutClick = this.handleZoomOutClick.bind(this);
    this.imageLoaded = this.imageLoaded.bind(this);
    this.imageChange = this.imageChange.bind(this);
  }

  componentDidUpdate(prevProps) {
    const { viewer } = this.props;
    const { viewerFullyLoaded } = this.state;
    if (viewer && !viewerFullyLoaded) {
      viewer.addOnceHandler('tile-drawn', this.imageLoaded);
      viewer.addOnceHandler('close', this.imageChange);
    }
  }

  imageLoaded() {
    const { viewer } = this.props;
    this.setState({viewerFullyLoaded: true});
    viewer.removeHandler('tile-drawn', this.imageLoaded);
  }

  imageChange() {
    const { viewer } = this.props;
    this.setState({viewerFullyLoaded: false});
    viewer.removeHandler('close', this.imageChange);
  }

  /**
   * @private
   */
  handleZoomInClick() {
    const { windowId, updateViewport, viewer, windowViewProperties } = this.props;
    if (windowViewProperties.zoom <= viewer.viewport.getMaxZoom()) {
      updateViewport(windowId, {
        zoom: windowViewProperties.zoom * 2,
      });
    }
  }

  /**
   * @private
   */
  handleZoomOutClick() {
    const { windowId, updateViewport, viewer, windowViewProperties } = this.props;
    if (windowViewProperties.zoom >= viewer.viewport.getMinZoom()) {
      updateViewport(windowId, {
        zoom: windowViewProperties.zoom / 2,
      });
    }
  }

  render() {
    const { classes, viewer, windowViewProperties } = this.props;
    const { viewerFullyLoaded } = this.state;
    const zoomIn = ( windowViewProperties && viewer && windowViewProperties.zoom < viewer.viewport.getMaxZoom() );
    const zoomOut = ( windowViewProperties && viewer && windowViewProperties.zoom > viewer.viewport.getMinZoom() );
    return (
      <div className={!viewerFullyLoaded && 'loader'}>
        <div className={'miradorZoomButtons'}>
          <ButtonGroup size='large' disableElevation variant='contained' color='primary' >
            <Button className={classes.CustomZoomButton} aria-label='zoom in' onClick={this.handleZoomInClick} disabled={!zoomIn}>
              <ZoomInIcon />
            </Button>
            <Button className={classes.CustomZoomButton} aria-label='zoom out' onClick={this.handleZoomOutClick} disabled={!zoomOut}>
              <ZoomOutIcon />
            </Button>
          </ButtonGroup>
        </div>
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
  component: withStyles(styles)(ZoomButtonsPlugin),
  mapStateToProps: mapStateToProps,
  target: 'OpenSeadragonViewer',
  mode: 'add',
};

