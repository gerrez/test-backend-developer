# Coding test
The purpose of this repository is to provide a sandbox for candidates completing our coding test.

The repository is only used for testing purposes, but all the code in the repository is either carbon copied 
from TestaViva production code, or heavily inspired from it. This also makes the test serve as an introduction into 
our business logic and help prepare you for a future employment.

## Concepts
You should know by now, that TestaViva is all about legal documents. For almost anything we do at TestaViva, legal 
documents are at the core. 
A document is a living entity. It will always start out as a draft, and will always end up being signed, and legally 
valid. On the journey from draft to signed, the document will pass through a lot of different states. The states in  
`DocumentState.php` is all possible states for a legal document.

Each `DocumentState` will have one or more `DocumentStages` (see `DocumentStage.php`). These stages will vary between
document types. By example will a testament (testamente) at the waiting for signature state not have the same stages as 
a Future Power of Attorney (fremtidsfuldmagt) waiting for signature.

To give our customers an overview of the stages they must go through to complete a document, we provide an overview of 
these stages. Watch the `demo.mov` video to have a look at this interface.

## Task
Your task is to implement the overview demonstrated in `demo.mov`. 
You must implement the `getProgress()` function in `Document.php`, to make this overview work and behave as in the video.
__Note: No frontend development is required. If you implement the `getProgress()` function as specified in its comment, 
everything will work out of the box.__ 
__Note: Beside the `getProgress()`, it should not be necessary to alter any existing methods. If you find a need to 
change an exising method, you are most likely on a wrong path.__

### Requirements
- Before starting the document, all stages must be listed (Udfyld, Køb, Juridisk hjælp, Tinglysning, Underskrift, Notar, 
Gyldigt)
- Whenever a new state is set (through the call to action buttons), the new state must be the active one (green 
background) and all the previous ones must have a green dot.
- When choosing __Purchase DIY__ the "Evt. juridisk hjælp" step must be excluded from the overview (watch the demo - 
when purchasing Do It Yourself, no meeting is require, and therefore this stage is removed to avoid confusing the 
customer).
- When editing the document (through the `Edit document` call to action button) at a state after "Udfyld dit dokument", 
the active state must return to "Udfyld dit dokument", but all the stages the document have already been at must have a 
green dot. (watch the demo).

### Hand in
When done, you must turn in the task by forking this repository and creating a Pull Request with your changes.

## Have fun :-)
 