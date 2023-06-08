"use strict";

const menuBtn = document.querySelector(".menu-btn");
const nav = document.querySelector(".navigation");
const menuOverlay = document.querySelector(".nav-overlay");
const carousels = document.querySelectorAll(".main-carousel");
const actualSlideDOM = document.querySelector(".acutalSlide");
const totalSlidesDOM = document.querySelector(".totalSlides");
let slideCounter = document.querySelector(".slides-counter");
const mainCarousel = document.querySelector(".main-carousel");
const infoButton = document.querySelector(".project-toggle button");
const header = document.querySelector(".fixed-container");
const infoContent = document.querySelector(".project-text");
let touchDevice = false;
const customCursor = document.querySelector("#besideMouse");
const cursorText = document.querySelector("#besideMouse p");
let buttonPrev;
let buttonNext;

window.onload = () => {
  customCursor.style.opacity = 0;
  if (!touchDevice) {
    customCursor.style.display = "block";
  } else {
    customCursor.style.display = "none";
  }
};

// Calculate Viewport height for VH
function resetHeight() {
  let viewportHeight = window.innerHeight + "px";
  let root = document.documentElement;
  let headerBottom = header?.getBoundingClientRect().bottom.toFixed();
  let minHeightImg = (window.innerWidth / 2) * 2.78 + "px";
  let maxHeightImg = window.innerHeight - headerBottom - 14 - 14 + "px";
  const projectTextHeight =
    document.querySelector(".project-text p")?.offsetHeight + "px";

  document.querySelector("body").style.height = viewportHeight;
  root.style.setProperty("--viewport-height", viewportHeight);
  root.style.setProperty("--max-height-img", maxHeightImg);
  root.style.setProperty("--min-height-img", minHeightImg);
  root.style.setProperty("--project-text-height", projectTextHeight);
}

if ("ontouchstart" in document.documentElement) {
  // touch events possible
  touchDevice = true;
} else {
  touchDevice = false;
}

window.addEventListener("resize", function () {
  resetHeight();
});
resetHeight();

// show and hide mobile Menu

let menuIsOpen;
if (nav?.classList.contains("menu-open")) {
  menuIsOpen;
} else {
  !menuIsOpen;
}

const showMenu = () => {
  if (menuIsOpen) {
    nav.classList.remove("menu-open");
    document.body.classList.remove("body-overflow");
    // menuOverlay.style.pointerEvents = "none";
  } else {
    nav.classList.add("menu-open");
    document.body.classList.add("body-overflow");
    // menuOverlay.style.pointerEvents = "auto";
  }
  menuIsOpen = !menuIsOpen;
};

const mobileMenuVisible = () => {
  const mobileMenuBtn = document.querySelector(".menu-btn");
  if (mobileMenuBtn !== null) {
    const isVisible = window
      .getComputedStyle(mobileMenuBtn)
      .getPropertyValue("display");
    if (isVisible == "none") {
      nav.classList.remove("mobile-menu");
      return false;
    } else {
      nav.classList.add("mobile-menu");
      return true;
    }
  }
};
mobileMenuVisible();

menuBtn ? menuBtn.addEventListener("click", showMenu) : undefined;
menuOverlay ? menuOverlay.addEventListener("click", showMenu) : undefined;

// Flickity Carousels

for (let carousel of carousels) {
  const flkty = new Flickity(carousel, {
    // options
    lazyLoad: 2,
    pageDots: false,
    wrapAround: false,
    dragThreshold: 0,
    selectedAttraction: 0.1,
    friction: 1,

    on: {
      ready: function () {
        totalSlidesDOM.innerHTML = this.cells.length - 1;
        buttonPrev = document.querySelector(".flickity-button.previous");
        buttonNext = document.querySelector(".flickity-button.next");
        buttonNext.style.width = "100%";
      },
      change: function (index) {
        const hideOnLastSlide = document.querySelectorAll(".hideOnLastSlide");
        if (index < this.cells.length - 1) {
          actualSlideDOM.innerHTML = index + 1;
          Array.from(hideOnLastSlide, (e) => (e.style.opacity = 1));
          infoContent.style.visibility = "visible";
          document.querySelector(".index-btn").style.visibility = "hidden";
          document.querySelector(".index-btn").style.opacity = 0;
          if (index > 0) {
            buttonNext.style.width = "50%";
            buttonPrev.style.width = "50%";
          } else if (index == 0) {
            buttonNext.style.width = "100%";
          }
        } else if (index == this.cells.length - 1) {
          Array.from(hideOnLastSlide, (e) => (e.style.opacity = 0));
          buttonPrev.style.width = "100%";
          infoContent.style.visibility = "hidden";
          document.querySelector(".index-btn").style.visibility = "visible";
          document.querySelector(".index-btn").style.opacity = 1;
        }
        player.pause();
      },
      settle: function (index) {
        document.onmouseover = (e) => changeTextOnCursor(e);
      },
    },
  });

  // DISABLE NEXT PREV BUTTONS ON MOBILE
  const flickitySlider = document.querySelector(".flickity-slider");
  if (touchDevice) {
    flickitySlider.style.pointerEvents = "auto";
  } else {
    flickitySlider.style.pointerEvents = "none";
  }
}

// FIX FOR BETTER SWIPE ON MOBILE DEVICES

(function () {
  var touchingCarousel = false,
    touchStartCoords;

  document.body.addEventListener("touchstart", function (e) {
    if (e.target.closest(".flickity-slider")) {
      touchingCarousel = true;
    } else {
      touchingCarousel = false;
      return;
    }

    touchStartCoords = {
      x: e.touches[0].pageX,
      y: e.touches[0].pageY,
    };
  });

  document.body.addEventListener(
    "touchmove",
    function (e) {
      if (!(touchingCarousel && e.cancelable)) {
        return;
      }

      var moveVector = {
        x: e.touches[0].pageX - touchStartCoords.x,
        y: e.touches[0].pageY - touchStartCoords.y,
      };

      if (Math.abs(moveVector.x) > 7) e.preventDefault();
    },
    { passive: false }
  );
})();

window.onresize = () => {
  mobileMenuVisible();
};

// TOGGLE INFOTEXT IN PROJECT-PAGE

infoButton
  ? (infoButton.onclick = function () {
      if (!infoContent.classList.contains("show-description")) {
        infoContent.classList.add("show-description");
        infoButton.innerHTML = "close";
      } else {
        infoContent.classList.remove("show-description");
        infoButton.innerHTML = "info";
      }
    })
  : undefined;

// CUSTOM CURSOR

const links = document.querySelectorAll(".fixed-container a");
const buttons = document.querySelectorAll(".fixed-container button");
const clickableElements = [...links, ...buttons];
const cursorSymbol = customCursor.querySelector(".cursorSymbol");

document.onmousemove = (e) => {
  customCursor.style.opacity = 1;
  changeTextOnCursor(e);
  let mousePosition = {
    x: e.clientX,
    y: e.clientY,
  };

  let offSet = {
    x: window.scrollX,
    y: window.scrollY,
  };

  // MOVE CUSTOM CUROSR
  customCursor.style.transform = `translate(${
    mousePosition.x + offSet.x + "px"
  }, ${mousePosition.y + offSet.y + "px"})`;

  // SCALE CURSOR WHEN HOVERING BUTTONS OR LINKS
  for (let link of [...clickableElements]) {
    if (link == e.target) {
      cursorSymbol.style.transform = "scale(1.8)";
      return;
    } else if (link !== e.target) {
      cursorSymbol.style.transform = "scale(1)";
    }
  }
};

function changeTextOnCursor(e) {
  if (e.target == buttonPrev) {
    cursorText.innerText = "Prev";
    cursorText.style.opacity = 1;
    cursorSymbol.style.opacity = 0;
  } else if (e.target == buttonNext) {
    cursorText.innerText = "Next";
    cursorText.style.opacity = 1;
    cursorSymbol.style.opacity = 0;
  } else if (e.target !== buttonNext || buttonPrev) {
    cursorText.style.opacity = 0;
    cursorSymbol.style.opacity = 1;
    return;
  }
}
