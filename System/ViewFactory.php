<?php

    namespace System;

    /**
     * This class extends Pandas View, this might be useful if you wanted to add a custom type of view caching
     */
    class ViewFactory extends Panda\ViewFactory
    {

        protected static $_instance;

    }