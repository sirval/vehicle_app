import React from "react";
import axios from "axios";

export const isAuth = () => {
    const userToken = localStorage.getItem("auth_token");
    if (!userToken || userToken === "undefined") {
      localStorage.removeItem("auth_token");
      return null;
    } else {
      return userToken;
    }
};