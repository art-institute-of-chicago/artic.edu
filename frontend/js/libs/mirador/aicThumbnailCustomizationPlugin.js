import React, { Component } from 'react';
import { withStyles } from '@material-ui/core/styles';

const styles = theme => ({
  insideLabel: {
    background: 'none',
  },
});

class ThumbnailPlugin extends Component {
  render() {
    const { TargetComponent } = this.props;
    return (
      <TargetComponent {...this.props}/>
    );
  }
}

export default {
  component: withStyles(styles)(ThumbnailPlugin),
  target: 'IIIFThumbnail',
  mode: 'wrap',
};

