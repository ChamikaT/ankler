#!/usr/bin/env python

import cv2
import numpy as np
import argparse
import pytesseract
from PIL import Image
from lxml import etree

STRING_PREDECESSORS = 'predecessors'
STRING_SUCCESSORS = 'successors'
STRING_ID = 'id'
STRING_CONTENT = 'content'
STRING_ROOT = 'root'
STRING_INJURY_LEVEL = 'injury_level'
STRING_DURATION = 'duration'
STRING_APPROACH = 'approach'
STRING_DESCRIPTION = 'description'
STRING_TREATMENT = 'treatment'
STRING_VALUE = 'value'
def get_rectangles(img_original):   

    hsv = cv2.cvtColor(img_original, cv2.COLOR_BGR2HSV)

    lower_red = np.array([0,20,0])
    upper_red = np.array([100,255,255])

    mask = cv2.inRange(hsv,lower_red, upper_red)

    blur = cv2.GaussianBlur(mask,(5,5),0)
    
    #cv2.imshow('blur', blur)
    
    ret3,th3 = cv2.threshold(blur,0,255,cv2.THRESH_BINARY)

    kernel = np.ones((5,5),np.uint8)
    opening = cv2.morphologyEx(th3, cv2.MORPH_OPEN, kernel)
    closing = cv2.morphologyEx(opening, cv2.MORPH_CLOSE, kernel)
    
    #cv2.imshow('close', closing)
    #cv2.waitKey(0)
    #cv2.destroyAllWindows()
    
    return closing

def get_Rect_Text(i , img_original):
    
    img, contours, hier = cv2.findContours(i, cv2.RETR_TREE,
                        cv2.CHAIN_APPROX_SIMPLE)        
    # with each contour, draw boundingRect in green
    nodes=[]
    d = 0
    with open('output.txt', 'w') as file:
        for c in contours:
            # get the bounding rect
            x, y, w, h = cv2.boundingRect(c)
               
            # draw a green rectangle to visualize the bounding rect
            cv2.rectangle(i, (x, y), (x+w, y+h), (0, 255, 0), 1)
    
            roi = img_original[y:y+h, x:x+w]
            
            cv2.imwrite('images/%d.png'%(d), roi)
            textarray = get_string(roi).splitlines()
            if(len(textarray) > 0) : 
#                print(textarray[0])
                file.write(textarray[0]+'\n') 
                nodes.append(getNodeFromLine(textarray[0], ' '.join(textarray[1:])))
            #print(get_string(roi))
            #print( "----------------------------------")
            d+=1
    print(len(contours))
    return nodes

def get_string(img1):
    # Convert to gray
    img = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
    
    # Apply dilation and erosion to remove some noise
    kernel = np.ones((1, 1), np.uint8)
    img = cv2.dilate(img, kernel, iterations=1)
    img = cv2.erode(img, kernel, iterations=1)
   
    #  Apply threshold to get image with only black and white
    img = cv2.adaptiveThreshold(img, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 31, 2)
    result = pytesseract.image_to_string(img)
        
    # Remove template file
    #os.remove(temp)

    return result

def getNodeFromLine(line, content):
    line = line.replace(" ", "")
#    print(line)
    first_sq_br = line.find('[')
    first_sq_br_inv = line.find(']')
    node_number = int(line[0:first_sq_br])
    predecessors = []
    predecessor_array = line[first_sq_br+1:first_sq_br_inv].split(',')
    for predecessor in predecessor_array:
        if predecessor != '':
            predecessors.append(int(predecessor))
    successors = []
    successor_array = line[first_sq_br_inv+2:len(line)-1].split(',')
    for successor in successor_array:
        if successor != '':
            successors.append(int(successor))
    node = {STRING_ID:node_number, STRING_PREDECESSORS:predecessors, STRING_SUCCESSORS:successors, STRING_CONTENT:content}
    print(node)
#    print( "----------------------------------")
    return node
def findRoots(nodes):
    roots = []
    for node in nodes:
#        print(node)
        if( len(node[STRING_PREDECESSORS]) == 0) :
            roots.append(node)
    return roots

def findNodeById(nodes, id):
    return next((item for item in nodes if item[STRING_ID] == id), None)
def generateXML(injury_levels, nodes):
    doc_root_tag = etree.Element(STRING_ROOT)
    
    for injury_level in injury_levels:
        injury_level_tag = etree.SubElement(doc_root_tag, STRING_INJURY_LEVEL, value= injury_level[STRING_CONTENT])
        for duration in injury_level[STRING_SUCCESSORS] :
            duration_node = findNodeById(nodes, duration)
            duration_tag = etree.SubElement(injury_level_tag, STRING_DURATION, value= duration_node[STRING_CONTENT])
            for approach in duration_node[STRING_SUCCESSORS]:
                approach_node = findNodeById(nodes, approach)
                approach_tag = etree.SubElement(duration_tag, STRING_APPROACH)
                description_tag = etree.SubElement(approach_tag, STRING_DESCRIPTION)
                description_tag.text = approach_node[STRING_CONTENT]
                for treatment in approach_node[STRING_SUCCESSORS]:
                    treatment_node = findNodeById(nodes, treatment)
                    treatment_tag = etree.SubElement(approach_tag, STRING_TREATMENT)
                    treatment_tag.text = treatment_node[STRING_CONTENT]
    doc = etree.ElementTree(doc_root_tag)   
    outFile = open('treatment.xml', 'wb')
    doc.write(outFile, pretty_print=True)
    outFile.close()
    
print ("-----------start------------")

#original_image = cv2.imread('Final_Diagram.png')
original_image = cv2.imread('TestDiagram.png')

filtered_image = get_rectangles(original_image)

cv2.imshow('filtered', filtered_image)
cv2.waitKey(0)
cv2.destroyAllWindows()
cv2.waitKey(1)
cv2.waitKey(1)
cv2.waitKey(1)
cv2.waitKey(1)
#filtered_start = get_start(original_image)
nodes = get_Rect_Text(filtered_image , original_image)
roots = findRoots(nodes)
generateXML(roots, nodes)
print("------------roots-------------")
print(roots)
print("------------end-------------")
input("")
