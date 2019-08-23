import { manageBehaviors } from '@area17/a17-helpers';
import closerLook  from './behaviors/closerLook';
import fontObservers  from './functions/fontObservers';

document.addEventListener('DOMContentLoaded', function(){
  const Behaviors = {
    closerLook
  };

  manageBehaviors(Behaviors);

  // watch for fonts loading
  fontObservers({
    name: 'serif',
    variants: [
      {
        name: 'Sabon',
        weight: '400',
        style: 'normal'
      },
      {
        name: 'Sabon',
        weight: '400',
        style: 'italic'
      },
      {
        name: 'Sabon',
        weight: '500',
        style: 'normal'
      },
    ]
  });
  fontObservers({
    name: 'sans-serif',
    variants: [
      {
        name: 'Ideal Sans A',
      },
      {
        name: 'Ideal Sans B',
        weight: '400',
        style: 'italic'
      },
    ]
  });
});
