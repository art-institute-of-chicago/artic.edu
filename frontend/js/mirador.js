import { manageBehaviors } from '@area17/a17-helpers';
import * as Behaviors from './behaviors/mirador';

document.addEventListener('DOMContentLoaded', function(){

  manageBehaviors(Behaviors);
});
