
// accordion pattern adapted from http://www.elated.com/articles/javascript-accordion/
var Accordion = {
    tabs:      [],
    bodies: [],

    // Initializes the accordion
    // @param int 'visibleItem':  The index of the accordionitem to show on startup
    init:       function (visibleItem) {
      // grab the accordion items from the page
      var itemsNodelist = document.querySelectorAll('.accordion_tab');
      Accordion.tabs = Array.prototype.slice.call(itemsNodelist); // converts the items Nodelist object to an array

      //attaches the toggleItem() event to all HTML elements with the 'accordionItem' class. IDEA turn into object method.
      for (var index = 0; index < Accordion.tabs.length; index++) {
        var tab = Accordion.tabs[index];
        Accordion.bodies.push(tab.nextElementSibling);
        Accordion.bodies[index].classList.add("hide_tag");
        Accordion.bodies[index].style.zIndex = index; //set the z-index for each accordion so they stack

        tab.onclick = Accordion.toggleItem.bind(Accordion); // assign onCLick handlers to each item
        //Also using bind() to transfer some properties to the onclick event.(not sure if I'm using it correctly)
      }
      console.log(Accordion.bodies);
      Accordion.setAccordionBodyVisibility(visibleItem);


    },
    //Hide all item bodies except for the one in the argument 'visible' TODO find better method name
    //parameter 1 'visible': int Index of the item to be shown
    setAccordionBodyVisibility: function(visibleBody){
      for (var index = 0; index < Accordion.bodies.length; index++) {
        var tab = Accordion.tabs[index];
        var body = Accordion.bodies[index];
        var triangle = tab.querySelector('.arrow_right');; // FIXME (triangle) will throw an error if this method is used on an element without that class e.g. when used to hide/show a menu.

        if (index !== visibleBody) {
          triangle.classList.remove("rotate_90");//FIXME (triangle)
          body.classList.add("closed");

        }
        else { // rotate the selected item's triangle and remove hide class
          body.classList.remove("closed");
          triangle.classList.add("rotate_90"); // FIXME (triangle)
        }


      }
    },

    toggleItem: function (event){
        var target = event.target || event.srcElement;
        event = event || window.event // cross-browser event
        event.stopPropagation
            ? event.stopPropagation()
            : (event.cancelBubble=true); //stop the event from bubbling

        var tab = Accordion.findAncestor(target, 'accordion_tab');

        var itemAccordionIndex = Accordion.tabs.indexOf(tab);
        console.log(tab);
        this.setAccordionBodyVisibility(itemAccordionIndex);
    },
    // searches ancestors of given element for a given classname
    // returns ancestor element
    findAncestor: function  (element, className) {
      while ( !element.classList.contains(className)){
        element = element.parentElement;
      }
      return element;
    }
}

Accordion.init(0);
