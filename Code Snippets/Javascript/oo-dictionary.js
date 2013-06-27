/**
 *
 *      Dictionary functions used to accurately get a list of and manipulate a set of object's properties
 *      See /Ebooks/Javascript/Eloquent-JavaScript/Code-Examples/chapter-8/
 */

/**
*  Utility loop function to check if an object has a property
*/
function forEachPropertyInObject(object, action) {
    for (var property in object) {
        if (Object.prototype.hasOwnProperty.call(object, property))
            action(property, object[property]);
    }
}
/**
* A constructor and a prototype specifically for situations where
* we want to approach an object as just a set of properties
*/
/*
* Initialise the function
* If values are passed to the constuctor, assign them as properties
* or just create the empty object with inherent prototype properties
*/
function Dictionary(startValues) {
    this.values = startValues || {};
}
/**
* Used to store values in the object
*/
Dictionary.prototype.store = function(name, value) {
    this.values[name] = value;
};
/**
* Look up the vaue of a given property
*/
Dictionary.prototype.lookup = function(name) {
    return this.values[name];
};
/**
* Check if the object contains a property
*/
Dictionary.prototype.contains = function(name) {
    return Object.prototype.hasOwnProperty.call(this.values, name) &&
    Object.prototype.propertyIsEnumerable.call(this.values, name);
};
/**
* Used to store values in the object
*/
Dictionary.prototype.each = function(action) {
    forEachPropertyInObject(this.values, action);
};
var colours = new Dictionary({
    Grover: "blue",
    Elmo: "orange",
    Bert: "yellow"
});
console.log(colours.contains("Grover"));
console.log(colours.contains("constructor"));
colours.each(function(name, colour) {
    console.log(name, " is ", colour);
});