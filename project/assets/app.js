import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

const b1 = document.querySelector(".b1Content");
const b2 = document.querySelector(".b2Content");
const b3 = document.querySelector(".b3Content");
const b1Children = b1.children;
const b2Children = b2.children;
const b3Children = b3.children;
let sum = 0;

for (let index = 0; index < b2Children.length; index++) {
    sum = sum + b2Children[index].children.length;
    
}

for (let index = 0; index < b1Children.length; index++) {
    setTimeout(() => {
        if(index == b1Children.length -1){
            b1.style.transform = "translate(0)";
        }
        else{
            b1.style.transform = "translate(calc((-100% * " + (index + 1) + ") - 20px))";
        }
    }, 5000 * (index + 1));
}

for (let index = 0; index < sum; index++) {
    setTimeout(() => {
        if (index == sum - 1) {
            b2.style.transform = "translate(0)";
        }
        else{
            b2.style.transform = "translate(calc((-100% * " + (index + 1) + ") - " + (20 *(index + 1)) + "px))";
        }
    }, 5000 * (index + 1));
    
}

for (let index = 0; index < b3Children.length; index++) {
    setTimeout(() => {
        if(index == b3Children.length -1){
            b3.style.transform = "translate(0)";
        }
        else{
            b3.style.transform = "translate(calc((-100% * " + (index + 1) + ") - 20px))";
        }
    }, 5000 * (index + 1));
}

setInterval(() => {
    for (let index = 0; index < b1Children.length; index++) {
        setTimeout(() => {
            if(index == b1Children.length -1){
                b1.style.transform = "translate(0)";
            }
            else{
                b1.style.transform = "translate(calc((-100% * " + (index + 1) + ") - 20px))";
            }
        }, 5000 * (index + 1));
    }
}, 5000 * (b1Children.length));

setInterval(() => {
    for (let index = 0; index < sum; index++) {
        setTimeout(() => {
            if(index == sum-1){
                b2.style.transform = "translate(0)";
            }
            else{
                b2.style.transform = "translate(calc((-100% * " + (index + 1) + ") - " + (20 *(index + 1)) + "px))";
            }
        }, 5000 * (index + 1));
    }
}, 5000 * (sum));

setInterval(() => {
    for (let index = 0; index < b3Children.length; index++) {
        setTimeout(() => {
            if(index == b3Children.length -1){
                b3.style.transform = "translate(0)";
            }
            else{b3.style.transform = "translate(calc((-100% * " + (index + 1) + ") - 20px))";
            }
        }, 5000 * (index + 1));
    }
}, 5000 * (b3Children.length));