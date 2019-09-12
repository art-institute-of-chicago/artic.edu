import ReactDOM from "react-dom";
import "intersection-observer";
import React from "react";
import CloserLook, { Modal } from "closer-look";
import getAbsoluteHeight from "../functions/getAbsoluteHeight";

const closerLook = function(container) {
  const elements = [];

  const $a17 = document.getElementById("a17");
  let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
  let ticking = false;

  function update() {
    ticking = false;

    const diff = Math.abs(
      Math.min(0, container.offsetHeight - window.innerHeight - scrollTop)
    );
    const fromBottom = window.innerHeight * -1 + diff;
    const isStuck = fromBottom <= 0;

    document.documentElement.classList.toggle('s-closer-look-footer-stuck', isStuck);

    let elementsOffsetHeight = 0;

    if( elements.length > 0 ){
      elements.forEach(function(element) {
        if( element ){
          element.style.position = isStuck ? "fixed" : null;
          element.style.top = isStuck ? `${elementsOffsetHeight}px` : null;
          elementsOffsetHeight += getAbsoluteHeight(element);
        }
      });
    }

    $a17.style.minHeight = `${container.offsetHeight + elementsOffsetHeight}px`;
  }

  function requestTick() {
    if(!ticking) {
      requestAnimationFrame(update);
    }
    ticking = true;
  }

  function handleScroll() {
    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    requestTick();
  }

  function _init() {
    window.scrollTo(0,0);
    window.addEventListener("scroll", handleScroll);
    handleScroll();

    let target = container;
    while(target = target.nextElementSibling) {
      elements.push(target);
    }
    elements.push(document.getElementById('footer'));

    const props = {
      contentBundle: JSON.parse(
        document.querySelector("[data-closerLook-contentBundle]").innerHTML
      ),
      assetLibrary: JSON.parse(
        document.querySelector("[data-closerLook-assetLibrary]").innerHTML
      )
    };

    window.closerLook = props;

    Modal.setAppElement(container);
    ReactDOM.render(<CloserLook {...props} />, container);
  }

  this.destroy = function() {
    window.removeEventListener('resized', handleResize);
    window.removeEventListener("scroll", handleScroll);
    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default closerLook;
