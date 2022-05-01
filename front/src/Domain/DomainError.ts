export class DomainError extends Error {
  constructor(message?: string) {
    super(message); 
    const actualProto = new.target.prototype;
    //if (Object.setPrototypeOf) {
    Object.setPrototypeOf(this, actualProto);
    //} else {
      //this.__proto__ = actualProto;
    //}
  }
}
