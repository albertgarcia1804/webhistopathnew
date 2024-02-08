// src/services/authService.js
let isAuthenticated = false;
// let userRole = null;


export const setAuthenticated = (value) => {
  isAuthenticated = value;
};

export const getAuthenticated = () => isAuthenticated;

// export const setUserRole = (value) => {
//   userRole = value;
// };

// export const getUserRole = () => userRole;
