import { manageBehaviors } from '@area17/a17-helpers';
import closerLook  from './behaviors/closerLook';

document.addEventListener('DOMContentLoaded', function(){
  const Behaviors = {
    closerLook
  };

  manageBehaviors(Behaviors);
});
