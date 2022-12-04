import React from "react";
import {Routes, Route} from "react-router-dom";

import IndexArticles from '../components/Articles/Index.jsx';

import NotFound from "../components/NotFound";

const Router = () =>{
    return(
        <div>
            <Routes>
                <Route path="/" element={<IndexArticles/>}/>
                <Route path="/*" element={<NotFound/>}/>
            </Routes>
        </div>
    )
}
export default Router
