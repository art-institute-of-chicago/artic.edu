import React, { Component } from 'react';
import SvgIcon from '@material-ui/core/SvgIcon';
import IconButton from '@material-ui/core/IconButton';
import * as actions from 'mirador/dist/es/src/state/actions';
import {
  getSequenceViewingDirection,
  getNextCanvasGrouping,
  getPreviousCanvasGrouping,
} from 'mirador/dist/es/src/state/selectors';
import { withStyles } from '@material-ui/core/styles';

//custom icons
const PrevIcon = (props) => (
  <SvgIcon {...props}>
    <svg viewBox='0 0 24 24' id='icon--arrow--24' xmlns='http://www.w3.org/2000/svg'>
      <path d='M9 5.55c1.915 2.632 3.343 4.542 4.57 6.45-1.227 1.908-2.655 3.817-4.57 6.45l1.2.55c2.229-2.46 4.143-4.57 5.8-6.71v-.58C14.342 9.57 12.429 7.46 10.2 5z' fill='currentColor'>
      </path>
    </svg>
  </SvgIcon>
);

const NextIcon = (props) => (
  <SvgIcon {...props}>
    <svg viewBox='0 0 24 24' id='icon--arrow--24' xmlns='http://www.w3.org/2000/svg'>
      <path d='M9 5.55c1.915 2.632 3.343 4.542 4.57 6.45-1.227 1.908-2.655 3.817-4.57 6.45l1.2.55c2.229-2.46 4.143-4.57 5.8-6.71v-.58C14.342 9.57 12.429 7.46 10.2 5z' fill='currentColor'>
      </path>
    </svg>
  </SvgIcon>
);

const styles = theme => ({
  CustomButtonPrevious: {
    transform: 'scale(1.5) rotate(180deg)',
    left: '5%',
    position: 'absolute',
    '&:hover': {
      backgroundColor: 'rgba(255, 255, 255, 0.0)',
    },
  },
  CustomButtonNext: {
    transform: 'scale(1.5)',
    right: '5%',
    position: 'absolute',
    '&:hover': {
      backgroundColor: 'rgba(255, 255, 255, 0.0)',
    },
  },
});

class NavigationButtonsPlugin extends Component {
  render() {
    const {
      classes, hasNextCanvas, hasPreviousCanvas, setNextCanvas, setPreviousCanvas, t,
    } = this.props;

    return (
      <div style={{position: 'absolute', bottom: '50%', zIndex:500, width:'100%'}}>
        <IconButton className={classes.CustomButtonPrevious} aria-label='previous canvas'  disabled={!hasPreviousCanvas} onClick={() => { hasPreviousCanvas && setPreviousCanvas(); }}>
          <PrevIcon className={'navButtons'} />
        </IconButton>
        <IconButton className={classes.CustomButtonNext} aria-label='next canvas' disabled={!hasNextCanvas} onClick={() => { hasNextCanvas && setNextCanvas(); }}>
          <NextIcon className={'navButtons'} />
        </IconButton>
      </div>
    );
  }
}

const mapStateToProps = (state, { windowId }) => (
  {
    hasNextCanvas: !!getNextCanvasGrouping(state, { windowId }),
    hasPreviousCanvas: !!getPreviousCanvasGrouping(state, { windowId }),
    viewingDirection: getSequenceViewingDirection(state, { windowId }),
  }
);

/**
 * mapDispatchToProps - used to hook up connect to action creators
 * @memberof ManifestForm
 * @private
 */
const mapDispatchToProps = (dispatch, { windowId }) => ({
  setNextCanvas: (...args) => dispatch(actions.setNextCanvas(windowId)),
  setPreviousCanvas: (...args) => dispatch(actions.setPreviousCanvas(windowId)),
});

export default {
  component: withStyles(styles)(NavigationButtonsPlugin),
  mapStateToProps: mapStateToProps,
  mapDispatchToProps: mapDispatchToProps,
  target: 'OpenSeadragonViewer',
  mode: 'add',
};

