export const protectFromUnmount = () => {
    let callbacks = {};
    let count = 0;
    const noop = value => value;
  
    const wrapCallback = id => function (...params) {
      const raceSafeCallbacks = callbacks;
  
      if (!raceSafeCallbacks) {
        return noop(...params);
      }
  
      const callback = raceSafeCallbacks[id];
      delete raceSafeCallbacks[id];
      return callback(...params);
    };
  
    const protect = (callback) => {
      const raceSafeCallbacks = callbacks;
  
      if (!raceSafeCallbacks) {
        return noop;
      }
  
      const id = count++;
      raceSafeCallbacks[id] = callback;
      return wrapCallback(id);
    };
  
    protect.unmount = () => (callbacks = null);
    return protect;
  }
  