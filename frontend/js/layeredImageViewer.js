import { manageBehaviors } from '@area17/a17-helpers';
import * as Behaviors from './behaviors/layeredImageViewer';

document.addEventListener('DOMContentLoaded', function() {
  manageBehaviors(Behaviors);
});
