import React, { Component } from 'react';
import { withStyles } from '@material-ui/core/styles';

const styles = theme => ({
  insideLabel: {
    background: 'none',
  },
});

class ThumbnailPlugin extends Component {
  render() {
    //accessing target component and its props
    const { TargetComponent, targetProps } = this.props
    //copy classes 
    targetProps.classes = this.props.classes;
    return (
      //return one set of thumbnails instead of two
      <TargetComponent {...this.props.targetProps}/>
    );
  }
}

export default {
  component: withStyles(styles)(ThumbnailPlugin),
  target: 'IIIFThumbnail',
  mode: 'wrap',
};

