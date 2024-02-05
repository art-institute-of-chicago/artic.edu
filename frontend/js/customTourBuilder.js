import { manageBehaviors } from '@area17/a17-helpers';
import * as Behaviors from './behaviors/customTourBuilder';

document.addEventListener('DOMContentLoaded', function() {
  manageBehaviors(Behaviors);
});
