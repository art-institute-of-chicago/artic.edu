import ReactDOM from 'react-dom';
import React, { useState } from 'react';


// This component is a placeholder for the custom tour builder
// It will be replaced with the an import from the remote repo in #186169509
const CustomTourBuilder = (props) => {
  const { initMessage } = props;
  const [message, setMessage] = useState(initMessage);
  return (
    <>
      <h1 className="f-headline" style={{marginBottom: '20px'}}>{message}</h1>
      <input type="text" value={message} onChange={e => setMessage(e.target.value)} />
    </>
  );
};

export default function customTourBuilder(container) {
  this.init = function () {
    ReactDOM.render(
      <CustomTourBuilder
        initMessage="Custom Tour Builder will render here!"
      />,
      container
    );
  }
  this.destroy = function () {
    ReactDOM.unmountComponentAtNode(container);
  }
}
